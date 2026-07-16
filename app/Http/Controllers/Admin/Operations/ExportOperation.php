<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Jobs\ProcessExportJob;
use App\Models\ExportJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Trait ExportOperation
 *
 * Custom Backpack operation that exports the current List query to an
 * XLSX file in the background, with progress and cancellation support.
 *
 * Concurrency model:
 *   - At most ONE in-flight (queued/processing) job per (crud_key, user_id).
 *   - Completed/cancelled/failed jobs are NOT counted as in-flight, so the
 *     user can always start a new export after one has finished, even if
 *     they haven't downloaded the previous file yet.
 *
 * Usage in a CrudController:
 *   use \App\Http\Controllers\Admin\Operations\ExportOperation;
 *
 * Optional hooks the controller can override:
 *   - exportWithRelations(): array  // eager-loaded relations
 *   - exportSelectColumns(): array  // SELECT list to keep payload small
 *   - exportPreloadCallback(\Illuminate\Database\Eloquent\Builder $base): void
 *         // chance to build N+1-killing lookup maps in ExportContext
 *   - exportFileName(): string
 */
trait ExportOperation
{
    /**
     * Register the routes used by this operation.
     */
    protected function setupExportRoutes($segment, $routeName, $controller)
    {
        Route::post($segment . '/export/start', [
            'as'   => $routeName . '.exportStart',
            'uses' => $controller . '@startExport',
            'operation' => 'export',
        ]);

        Route::get($segment . '/export/progress/{jobId}', [
            'as'   => $routeName . '.exportProgress',
            'uses' => $controller . '@exportProgress',
            'operation' => 'export',
        ]);

        Route::post($segment . '/export/cancel/{jobId}', [
            'as'   => $routeName . '.exportCancel',
            'uses' => $controller . '@cancelExport',
            'operation' => 'export',
        ]);

        Route::get($segment . '/export/download/{jobId}', [
            'as'   => $routeName . '.exportDownload',
            'uses' => $controller . '@downloadExport',
            'operation' => 'export',
        ]);

        Route::get($segment . '/export/active', [
            'as'   => $routeName . '.exportActive',
            'uses' => $controller . '@activeExport',
            'operation' => 'export',
        ]);

        Route::get($segment . '/export/history', [
            'as'   => $routeName . '.exportHistory',
            'uses' => $controller . '@exportHistory',
            'operation' => 'export',
        ]);

        Route::delete($segment . '/export/{jobId}', [
            'as'   => $routeName . '.exportDelete',
            'uses' => $controller . '@deleteExport',
            'operation' => 'export',
        ]);
    }

    /**
     * Hook into the List operation to inject the export button.
     */
    protected function setupExportDefaults(): void
    {
        $this->crud->allowAccess('export');

        $this->crud->operation('list', function () {
            $this->crud->addButton(
                'top',
                'custom_export',
                'view',
                'crud::buttons.custom_export',
                'end'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ENDPOINTS
    |--------------------------------------------------------------------------
    */

    /**
     * Start a new export job.
     */
    public function startExport(): JsonResponse
    {
        $this->crud->hasAccessOrFail('export');

        $crudKey = $this->getExportCrudKey();
        $userId  = backpack_user()->id;

        $active = ExportJob::forCrud($crudKey)->forUser($userId)->active()->first();
        if ($active) {
            return response()->json([
                'status'  => 'already_running',
                'job_id'  => $active->id,
                'message' => 'یک خروجی فعال برای این لیست در حال انجام است.',
            ], 409);
        }

        $filtersSnapshot = request()->query();

        $job = ExportJob::create([
            'crud_key'   => $crudKey,
            'user_id'    => $userId,
            'status'     => ExportJob::STATUS_QUEUED,
            'filters'    => $filtersSnapshot,
            'file_name'  => $this->resolveExportFileName(),
            'expires_at' => now()->addDays(2),
        ]);

        ProcessExportJob::dispatch(
            $job->id,
            static::class,
            $crudKey,
            $userId,
            $filtersSnapshot
        )->onQueue('exports');

        return response()->json([
            'status' => 'started',
            'job_id' => $job->id,
        ]);
    }

    /**
     * Return the progress of a single job (polled by the frontend).
     */
    public function exportProgress(int $jobId): JsonResponse
    {
        $job = ExportJob::findOrFail($jobId);
        $this->authorizeJob($job);

        return response()->json([
            'id'              => $job->id,
            'status'          => $job->status,
            'progress'        => $job->progress_percent,
            'processed_rows'  => $job->processed_rows,
            'total_rows'      => $job->total_rows,
            'error_message'   => $job->error_message,
            'is_downloadable' => $job->isCompleted() && $job->file_path,
        ]);
    }

    /**
     * Request cancellation of a job.
     */
    public function cancelExport(int $jobId): JsonResponse
    {
        $job = ExportJob::findOrFail($jobId);
        $this->authorizeJob($job);

        if ($job->isActive()) {
            $job->markCancelRequested();
        }

        return response()->json(['status' => 'cancel_requested']);
    }

    /**
     * Stream the completed file to the browser.
     */
    public function downloadExport(int $jobId): BinaryFileResponse
    {
        $job = ExportJob::findOrFail($jobId);
        $this->authorizeJob($job);

        abort_unless($job->isCompleted() && $job->file_path, 404);

        $disk = Storage::disk('local');
        abort_unless($disk->exists($job->file_path), 404);

        return response()->download(
            $disk->path($job->file_path),
            $job->file_name ?: ($this->getExportCrudKey() . '.xlsx')
        );
    }

    /**
     * Lightweight check used on page load: is there an in-flight job?
     */
    public function activeExport(): JsonResponse
    {
        $crudKey = $this->getExportCrudKey();
        $userId  = backpack_user()->id;

        $job = ExportJob::forCrud($crudKey)
            ->forUser($userId)
            ->active()
            ->latest('id')
            ->first();

        if (!$job) {
            return response()->json(['has_job' => false]);
        }

        return response()->json([
            'has_job'         => true,
            'id'              => $job->id,
            'status'          => $job->status,
            'progress'        => $job->progress_percent,
            'processed_rows'  => $job->processed_rows,
            'total_rows'      => $job->total_rows,
            'is_downloadable' => false,
        ]);
    }

    /**
     * Return the history of export jobs for the current user + crud.
     *
     * Used by the "history" modal on the frontend.
     */
    public function exportHistory(): JsonResponse
    {
        $this->crud->hasAccessOrFail('export');

        $crudKey = $this->getExportCrudKey();
        $userId  = backpack_user()->id;

        $jobs = ExportJob::forCrud($crudKey)
            ->forUser($userId)
            ->orderByDesc('id')
            ->limit(50)
            ->get();

        $items = $jobs->map(function (ExportJob $job) {
            return [
                'id'              => $job->id,
                'status'          => $job->status,
                'status_label'    => $this->translateExportStatus($job->status),
                'progress'        => $job->progress_percent,
                'processed_rows'  => $job->processed_rows,
                'total_rows'      => $job->total_rows,
                'file_name'       => $job->file_name,
                'file_size'       => $job->file_size,
                'file_size_human' => $job->file_size ? $this->humanFileSize((int) $job->file_size) : null,
                'is_downloadable' => $job->isCompleted() && $job->file_path
                    && Storage::disk('local')->exists($job->file_path),
                'error_message'   => $job->error_message,
                'created_at'      => optional($job->created_at)->format('Y-m-d H:i'),
                'completed_at'    => optional($job->completed_at)->format('Y-m-d H:i'),
            ];
        });

        return response()->json([
            'items' => $items,
        ]);
    }

    /**
     * Delete an export job and its associated file.
     *
     * Active jobs cannot be deleted — they must be cancelled first.
     */
    public function deleteExport(int $jobId): JsonResponse
    {
        $job = ExportJob::findOrFail($jobId);
        $this->authorizeJob($job);

        if ($job->isActive()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'این خروجی هنوز فعال است. ابتدا آن را لغو کنید.',
            ], 422);
        }

        if ($job->file_path) {
            Storage::disk('local')->delete($job->file_path);
        }

        $job->delete();

        return response()->json(['status' => 'deleted']);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    protected function getExportCrudKey(): string
    {
        $route = trim($this->crud->getRoute(), '/');
        $segments = explode('/', $route);
        return end($segments) ?: $route;
    }

    protected function resolveExportFileName(): string
    {
        if (method_exists($this, 'exportFileName')) {
            return $this->exportFileName();
        }
        return $this->getExportCrudKey() . '_' . now()->format('Ymd_His') . '.xlsx';
    }

    protected function authorizeJob(ExportJob $job): void
    {
        abort_unless($job->user_id === backpack_user()->id, 403);
        abort_unless($job->crud_key === $this->getExportCrudKey(), 403);
    }

    /**
     * Persian-friendly status label for the history view.
     */
    protected function translateExportStatus(string $status): string
    {
        return [
            ExportJob::STATUS_QUEUED     => 'در صف',
            ExportJob::STATUS_PROCESSING => 'در حال پردازش',
            ExportJob::STATUS_COMPLETED  => 'تکمیل شده',
            ExportJob::STATUS_CANCELLED  => 'لغو شده',
            ExportJob::STATUS_FAILED     => 'ناموفق',
        ][$status] ?? $status;
    }

    /**
     * Format a byte count as KB/MB/GB.
     */
    protected function humanFileSize(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes . ' B';
        }
        $units = ['KB', 'MB', 'GB', 'TB'];
        $i = -1;
        do {
            $bytes /= 1024;
            $i++;
        } while ($bytes >= 1024 && $i < count($units) - 1);
        return number_format($bytes, 2) . ' ' . $units[$i];
    }
}
