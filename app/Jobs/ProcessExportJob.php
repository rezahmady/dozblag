<?php

namespace App\Jobs;

use App\Models\ExportJob;
use App\Support\Export\CellValueExtractor;
use App\Support\Export\ExportContext;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Writer\XLSX\Options;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class ProcessExportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $timeout = 7200;
    public int $tries = 1;

    protected const CHUNK_SIZE = 1000;
    protected const PROGRESS_INTERVAL = 500;

    public function __construct(
        public int $exportJobId,
        public string $controllerClass,
        public string $crudKey,
        public int $userId,
        public array $filters
    ) {
    }

    public function handle(): void
    {
        /** @var ExportJob $job */
        $job = ExportJob::find($this->exportJobId);
        if (!$job || (!$job->isActive() && $job->status !== ExportJob::STATUS_QUEUED)) {
            return;
        }

        $job->update([
            'status'     => ExportJob::STATUS_PROCESSING,
            'started_at' => now(),
        ]);

        $writer        = null;
        $relativePath  = null;
        $absolutePath  = null;

        try {
            $this->bootFakeRequest();
            $crudPanel  = $this->bootCrudPanel();
            $controller = $this->bootController($crudPanel);

            $query   = clone $controller->crud->query;
            $columns = $this->collectColumns($controller);
            $query   = $this->prepareQuery($controller, $query);

            // Total = DISTINCT count of primary keys.
            // This matches what the user sees in the list view and avoids
            // duplicate inflation from whereHas/joins.
            $total = $this->countDistinct($query);
            $job->update(['total_rows' => $total]);

            [$writer, $relativePath, $absolutePath] = $this->openWriter($job);
            $this->writeHeader($writer, $columns);

            ExportContext::enter();

            if (method_exists($controller, 'exportPreloadCallback')) {
                $controller->exportPreloadCallback(clone $query);
            }

            // Cursor-based streaming with explicit PK pagination.
            // We DO NOT rely on chunkById here because the underlying
            // CRUD query may contain user-defined orderByRaw clauses,
            // joins, or DISTINCT-affecting filters which break chunkById's
            // assumption of a single, monotonically increasing PK ordering.
            $processed   = 0;
            $lastUpdate  = 0;
            $cancelled   = false;

            $keyName    = $query->getModel()->getKeyName();
            $qualifiedKey = $query->getModel()->getQualifiedKeyName();
            $lastId     = 0;
            $seenIds    = []; // safeguard against accidental duplicates

            while (true) {
                $batchQuery = clone $query;

                // Strip the controller's order clauses for paging,
                // then enforce PK-asc so cursor pagination is correct.
                $batchQuery->getQuery()->orders = null;
                $batchQuery->getQuery()->unionOrders = null;

                // Avoid duplicates from join/whereHas-introduced cartesian rows.
                $batchQuery->distinct();

                $rows = $batchQuery
                    ->where($qualifiedKey, '>', $lastId)
                    ->orderBy($qualifiedKey, 'asc')
                    ->limit(self::CHUNK_SIZE)
                    ->get();

                if ($rows->isEmpty()) {
                    break;
                }

                foreach ($rows as $entry) {
                    $id = $entry->getKey();
                    $lastId = max($lastId, $id);

                    if (isset($seenIds[$id])) {
                        continue;
                    }
                    $seenIds[$id] = true;

                    $cells = [];
                    foreach ($columns as $column) {
                        $cells[] = CellValueExtractor::extract($entry, $column);
                    }
                    $writer->addRow(Row::fromValues($cells));
                    $processed++;

                    if ($processed - $lastUpdate >= self::PROGRESS_INTERVAL) {
                        $lastUpdate = $processed;

                        $fresh = ExportJob::find($job->id);
                        if ($fresh && $fresh->cancel_requested) {
                            $cancelled = true;
                            break 2;
                        }

                        $job->update([
                            'processed_rows'   => $processed,
                            'progress_percent' => $job->total_rows > 0
                                ? min(99, (int) floor(($processed / $job->total_rows) * 100))
                                : 0,
                        ]);
                    }
                }

                // Keep the seen-id map bounded: we only need to dedupe
                // *within* the current batch, since the next batch starts
                // strictly after lastId.
                $seenIds = [];
                unset($rows);
                gc_collect_cycles();
            }

            $writer->close();
            $writer = null;

            if ($cancelled) {
                @Storage::disk('local')->delete($relativePath);
                $job->update([
                    'status'       => ExportJob::STATUS_CANCELLED,
                    'completed_at' => now(),
                ]);
                return;
            }

            $job->update([
                'status'           => ExportJob::STATUS_COMPLETED,
                'processed_rows'   => $processed,
                'progress_percent' => 100,
                'file_path'        => $relativePath,
                'file_size'        => Storage::disk('local')->size($relativePath),
                'completed_at'     => now(),
            ]);
        } catch (\Throwable $e) {
            if ($writer) {
                try { $writer->close(); } catch (\Throwable $ignore) {}
            }
            if ($relativePath) {
                @Storage::disk('local')->delete($relativePath);
            }
            $job->update([
                'status'        => ExportJob::STATUS_FAILED,
                'error_message' => mb_substr($e->getMessage(), 0, 1000),
                'completed_at'  => now(),
            ]);
            report($e);
            throw $e;
        } finally {
            ExportContext::leave();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | INTERNAL
    |--------------------------------------------------------------------------
    */

    protected function bootFakeRequest(): void
    {
        $request = Request::create('/', 'GET', $this->filters);
        app()->instance('request', $request);
        \Illuminate\Support\Facades\Request::swap($request);

        if ($this->userId) {
            Auth::guard(config('backpack.base.guard', 'backpack'))
                ->loginUsingId($this->userId);
        }
    }

    protected function bootCrudPanel(): CrudPanel
    {
        app()->forgetInstance(CrudPanel::class);
        app()->forgetInstance('crud');
        CRUD::clearResolvedInstance(CrudPanel::class);
        CRUD::clearResolvedInstance('crud');

        $panel = new CrudPanel();
        app()->instance(CrudPanel::class, $panel);
        app()->instance('crud', $panel);

        return $panel;
    }

    protected function bootController(CrudPanel $panel)
    {
        $controller = new $this->controllerClass();
        $this->forceInjectCrud($controller, $panel);

        $controller->crud->setOperation('list');
        if (method_exists($controller->crud, 'setRequest')) {
            $controller->crud->setRequest(request());
        }

        $this->invokeControllerMethod($controller, 'setup');
        $this->invokeControllerMethod($controller, 'setupListOperation');

        if (method_exists($controller->crud, 'applyUnappliedFilters')) {
            $controller->crud->applyUnappliedFilters();
        }

        return $controller;
    }

    protected function invokeControllerMethod(object $controller, string $method): void
    {
        $reflection = new ReflectionClass($controller);
        if (!$reflection->hasMethod($method)) {
            return;
        }
        /** @var ReflectionMethod $m */
        $m = $reflection->getMethod($method);
        $m->setAccessible(true);
        $m->invoke($controller);
    }

    protected function forceInjectCrud(object $controller, CrudPanel $panel): void
    {
        $reflection = new ReflectionClass($controller);
        while ($reflection) {
            if ($reflection->hasProperty('crud')) {
                /** @var ReflectionProperty $prop */
                $prop = $reflection->getProperty('crud');
                $prop->setAccessible(true);
                $prop->setValue($controller, $panel);
                return;
            }
            $reflection = $reflection->getParentClass();
        }
    }

    protected function collectColumns($controller): array
    {
        if (method_exists($controller, 'exportColumns')) {
            $custom = $controller->exportColumns();
            if (!empty($custom)) {
                return $custom;
            }
        }
        $columns = $controller->crud->columns();
        return array_values(array_filter($columns, function ($col) {
            return empty($col['exportable']) || $col['exportable'] !== false;
        }));
    }

    protected function prepareQuery($controller, $query)
    {
        $query->setEagerLoads([]);
        if (method_exists($controller, 'exportWithRelations')) {
            $relations = $controller->exportWithRelations();
            if (!empty($relations)) {
                $query->with($relations);
            }
        }
        if (method_exists($controller, 'exportSelectColumns')) {
            $select = $controller->exportSelectColumns();
            if (!empty($select)) {
                $query->select($select);
            }
        }
        return $query;
    }

    /**
     * Count DISTINCT primary keys for the given query, matching what the
     * user would see in the paginated list.
     */
    protected function countDistinct($query): int
    {
        $countQuery = clone $query;
        $countQuery->getQuery()->orders = null;
        $countQuery->getQuery()->unionOrders = null;

        $keyName = $countQuery->getModel()->getQualifiedKeyName();

        return (int) $countQuery->distinct()->count($keyName);
    }

    protected function openWriter(ExportJob $job): array
    {
        $dir = 'exports/' . $job->crud_key;
        Storage::disk('local')->makeDirectory($dir);

        $fileName     = 'export_' . $job->id . '_' . now()->format('Ymd_His') . '.xlsx';
        $relativePath = $dir . '/' . $fileName;
        $absolutePath = Storage::disk('local')->path($relativePath);

        $options = new Options();
        $options->DEFAULT_ROW_STYLE = (new Style())->setFontName('Tahoma')->setFontSize(10);

        $writer = new Writer($options);
        $writer->openToFile($absolutePath);

        return [$writer, $relativePath, $absolutePath];
    }

    protected function writeHeader(Writer $writer, array $columns): void
    {
        $headerStyle = (new Style())
            ->setFontBold()
            ->setFontName('Tahoma')
            ->setFontSize(11);

        $headers = [];
        foreach ($columns as $column) {
            $label = $column['label'] ?? $column['name'] ?? '';
            $headers[] = trim(strip_tags(html_entity_decode(
                $label,
                ENT_QUOTES | ENT_HTML5,
                'UTF-8'
            )));
        }
        $writer->addRow(Row::fromValues($headers, $headerStyle));
    }
}
