<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExportJob
 *
 * Represents a single export task tracked in the database.
 * Used by the custom ExportOperation to manage progress, cancellation,
 * and file delivery for long-running exports.
 *
 * @property int    $id
 * @property string $crud_key
 * @property int    $user_id
 * @property string $status
 * @property int    $total_rows
 * @property int    $processed_rows
 * @property int    $progress_percent
 * @property array  $filters
 * @property bool   $cancel_requested
 * @property string $file_path
 * @property string $file_name
 * @property int    $file_size
 * @property string $error_message
 */
class ExportJob extends Model
{
    protected $table = 'export_jobs';

    protected $guarded = ['id'];

    protected $casts = [
        'filters'          => 'array',
        'cancel_requested' => 'boolean',
        'started_at'       => 'datetime',
        'completed_at'     => 'datetime',
        'expires_at'       => 'datetime',
    ];

    /** Statuses */
    public const STATUS_QUEUED     = 'queued';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED  = 'completed';
    public const STATUS_CANCELLED  = 'cancelled';
    public const STATUS_FAILED     = 'failed';

    /**
     * Statuses that represent an "in-flight" (not finished) job.
     */
    public const ACTIVE_STATUSES = [
        self::STATUS_QUEUED,
        self::STATUS_PROCESSING,
    ];

    /**
     * Statuses that represent a finished job (terminal state).
     */
    public const FINISHED_STATUSES = [
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED,
        self::STATUS_FAILED,
    ];

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeForCrud(Builder $query, string $crudKey): Builder
    {
        return $query->where('crud_key', $crudKey);
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', self::ACTIVE_STATUSES);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return in_array($this->status, self::ACTIVE_STATUSES, true);
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Mark the job as cancelled (does not delete file - cleanup handles that).
     */
    public function markCancelRequested(): void
    {
        $this->update(['cancel_requested' => true]);
    }
}
