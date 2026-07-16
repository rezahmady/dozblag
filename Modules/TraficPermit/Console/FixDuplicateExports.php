<?php

namespace Modules\TraficPermit\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\TraficPermit\Enums\TransactionType;

class FixDuplicateExports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'traficpermit:fix-duplicate-exports {--dry-run : List duplicates without deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove duplicate permit exports and refund related withdraw transactions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dryRun = (bool) $this->option('dry-run');

        if ($dryRun) {
            $this->warn('Dry-run mode: no changes will be written.');
        }

        $deletedExports = 0;
        $deletedOrphans = 0;
        $refundedAmount = 0;
        $sampleDeletedIds = [];
        $duplicateGroupCount = 0;

        // --- status=1 duplicates ---
        $duplicateGroups = DB::table('permit_order_trafic_permit')
            ->select('permit_order_id', 'trafic_permit_id', DB::raw('COUNT(*) as total'))
            ->where('status', 1)
            ->groupBy('permit_order_id', 'trafic_permit_id')
            ->having('total', '>', 1)
            ->get();

        $duplicateGroupCount = $duplicateGroups->count();
        $this->info("Found {$duplicateGroupCount} duplicate status=1 group(s).");

        foreach ($duplicateGroups as $group) {
            $exports = DB::table('permit_order_trafic_permit')
                ->select('id', 'get_carcasses_at', 'is_recursive')
                ->where('permit_order_id', $group->permit_order_id)
                ->where('trafic_permit_id', $group->trafic_permit_id)
                ->where('status', 1)
                ->orderByRaw('CASE WHEN get_carcasses_at IS NULL THEN 1 ELSE 0 END')
                ->orderBy('id')
                ->get();

            // Prefer delivered / recursive history as the keeper
            $keep = $exports->first(fn ($e) => ! empty($e->get_carcasses_at) || $this->isRecursive($e))
                ?? $exports->sortBy('id')->first();

            // Only bug-race leftovers: no delivery date and not recursive
            $toDeleteIds = $exports
                ->filter(fn ($e) => (int) $e->id !== (int) $keep->id)
                ->filter(fn ($e) => empty($e->get_carcasses_at) && ! $this->isRecursive($e))
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->values()
                ->all();

            if (empty($toDeleteIds)) {
                $this->warn(sprintf(
                    'Skip group order=%s permit=%s — no safe deletable duplicates (history preserved, keep=%s)',
                    $group->permit_order_id,
                    $group->trafic_permit_id,
                    $keep->id
                ));
                continue;
            }

            $this->line(sprintf(
                'Group order=%s permit=%s keep=%s delete=[%s]',
                $group->permit_order_id,
                $group->trafic_permit_id,
                $keep->id,
                implode(',', $toDeleteIds)
            ));

            $refundedAmount += $this->refundAndDeleteExports($toDeleteIds, $dryRun, $sampleDeletedIds, $deletedExports);
        }

        // --- orphan drafts (status=0 with status=1 sibling) — bulk, no per-row logging ---
        $orphanQuery = DB::table('permit_order_trafic_permit as draft')
            ->where('draft.status', 0)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('permit_order_trafic_permit as sibling')
                    ->whereColumn('sibling.permit_order_id', 'draft.permit_order_id')
                    ->whereColumn('sibling.trafic_permit_id', 'draft.trafic_permit_id')
                    ->where('sibling.status', 1);
            });

        $orphanCount = (clone $orphanQuery)->count();
        $this->info("Found {$orphanCount} orphan status=0 draft(s) with finalized sibling.");

        if ($orphanCount > 0) {
            if ($dryRun) {
                $deletedOrphans += $orphanCount;
                $sampleIds = (clone $orphanQuery)->orderBy('draft.id')->limit(20)->pluck('draft.id')->all();
                $this->pushSampleIds($sampleDeletedIds, $sampleIds);

                // Include any unexpected withdraws on status=0 drafts in the refund total
                $refundedAmount += (int) DB::table('transactions')
                    ->where('status', 1)
                    ->where('type', TransactionType::Withdraw->value)
                    ->whereIn('trafic_permit_export_id', (clone $orphanQuery)->select('draft.id'))
                    ->sum('amount');
            } else {
                // Re-query each batch so deletes do not skip rows
                do {
                    $ids = (clone $orphanQuery)
                        ->orderBy('draft.id')
                        ->limit(500)
                        ->pluck('draft.id')
                        ->map(fn ($id) => (int) $id)
                        ->all();

                    if (empty($ids)) {
                        break;
                    }

                    $refundedAmount += $this->deleteExportIds($ids, false, $sampleDeletedIds, $deletedOrphans);
                    $this->line('Deleted orphan batch of '.count($ids).' (total: '.$deletedOrphans.')');
                } while (true);
            }
        }

        // --- duplicate drafts only ---
        $draftOnlyGroups = DB::table('permit_order_trafic_permit')
            ->select('permit_order_id', 'trafic_permit_id', DB::raw('COUNT(*) as total'))
            ->where('status', 0)
            ->groupBy('permit_order_id', 'trafic_permit_id')
            ->having('total', '>', 1)
            ->get();

        $this->info('Found '.$draftOnlyGroups->count().' draft-only duplicate group(s).');

        foreach ($draftOnlyGroups as $group) {
            $drafts = DB::table('permit_order_trafic_permit')
                ->select('id')
                ->where('permit_order_id', $group->permit_order_id)
                ->where('trafic_permit_id', $group->trafic_permit_id)
                ->where('status', 0)
                ->orderBy('id')
                ->get();

            $keepId = (int) $drafts->first()->id;
            $toDeleteIds = $drafts->where('id', '!=', $keepId)->pluck('id')->map(fn ($id) => (int) $id)->values()->all();

            $refundedAmount += $this->deleteExportIds($toDeleteIds, $dryRun, $sampleDeletedIds, $deletedOrphans);
        }

        $idsPreview = empty($sampleDeletedIds)
            ? '-'
            : implode(', ', $sampleDeletedIds).(count($sampleDeletedIds) >= 50 ? ' …' : '');

        $this->newLine();
        $this->info('Summary');
        $this->table(
            ['Metric', 'Value'],
            [
                ['Duplicate groups', $duplicateGroupCount],
                ['Deleted status=1 duplicates', $deletedExports],
                ['Deleted status=0 orphans', $deletedOrphans],
                ['Refunded withdraw amount', number_format($refundedAmount)],
                ['Sample deleted export IDs', $idsPreview],
            ]
        );

        return self::SUCCESS;
    }

    /**
     * Keep at most 50 sample IDs for the summary table.
     *
     * @param  array<int>  $sampleDeletedIds
     * @param  array<int>  $ids
     */
    protected function pushSampleIds(array &$sampleDeletedIds, array $ids): void
    {
        foreach ($ids as $id) {
            if (count($sampleDeletedIds) >= 50) {
                return;
            }
            $sampleDeletedIds[] = (int) $id;
        }
    }

    /**
     * @param  array<int>  $exportIds
     * @param  array<int>  $sampleDeletedIds
     */
    protected function refundAndDeleteExports(array $exportIds, bool $dryRun, array &$sampleDeletedIds, int &$deletedCount): int
    {
        return $this->deleteExportIds($exportIds, $dryRun, $sampleDeletedIds, $deletedCount);
    }

    /**
     * Delete export rows and refund any active Withdraw linked to them.
     *
     * @param  array<int>  $exportIds
     * @param  array<int>  $sampleDeletedIds
     */
    protected function deleteExportIds(array $exportIds, bool $dryRun, array &$sampleDeletedIds, int &$deletedCount): int
    {
        if (empty($exportIds)) {
            return 0;
        }

        $refunded = $this->sumActiveWithdrawAmount($exportIds);

        if ($dryRun) {
            $deletedCount += count($exportIds);
            $this->pushSampleIds($sampleDeletedIds, $exportIds);

            return $refunded;
        }

        DB::transaction(function () use ($exportIds, &$sampleDeletedIds, &$deletedCount) {
            DB::table('transactions')
                ->whereIn('trafic_permit_export_id', $exportIds)
                ->where('status', 1)
                ->where('type', TransactionType::Withdraw->value)
                ->delete();

            DB::table('transactions')
                ->whereIn('trafic_permit_export_id', $exportIds)
                ->update(['trafic_permit_export_id' => null]);

            DB::table('permit_order_trafic_permit')
                ->whereIn('id', $exportIds)
                ->delete();

            $deletedCount += count($exportIds);
            $this->pushSampleIds($sampleDeletedIds, $exportIds);
        }, 3);

        return $refunded;
    }

    /**
     * @param  array<int>  $exportIds
     */
    protected function sumActiveWithdrawAmount(array $exportIds): int
    {
        if (empty($exportIds)) {
            return 0;
        }

        return (int) DB::table('transactions')
            ->whereIn('trafic_permit_export_id', $exportIds)
            ->where('status', 1)
            ->where('type', TransactionType::Withdraw->value)
            ->sum('amount');
    }

    /**
     * Corrected / recursive history must never be treated as a bug duplicate.
     */
    protected function isRecursive(object $export): bool
    {
        return (bool) ($export->is_recursive ?? false);
    }
}
