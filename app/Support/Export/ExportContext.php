<?php

namespace App\Support\Export;

/**
 * Class ExportContext
 *
 * A lightweight runtime flag + cache container used during an export job.
 *
 * Why this exists:
 * --------------------------------------------------------------------------
 * When Backpack columns render in normal list view, model methods like
 * `$this->exports()->latest()->where('status', 1)->first()` run per row.
 * That is fine for a paginated list of 20 rows, but for a million-row export
 * it produces millions of queries (N+1 explosion).
 *
 * ExportContext lets the job preload the data once (using window-function /
 * grouped queries) and store it here in static maps. Then the model's
 * methods can check `ExportContext::isActive()` and read from the maps
 * instead of issuing fresh queries.
 *
 * The export job is responsible for calling enter() before chunking and
 * leave() in a try/finally block.
 */
class ExportContext
{
    /**
     * Whether an export is currently in progress in this PHP process.
     */
    protected static bool $active = false;

    /**
     * Generic preloaded data store.
     *
     * Shape: [string $bucket => [int $key => mixed $value]]
     */
    protected static array $store = [];

    public static function enter(): void
    {
        self::$active = true;
        self::$store  = [];
    }

    public static function leave(): void
    {
        self::$active = false;
        self::$store  = [];
    }

    public static function isActive(): bool
    {
        return self::$active;
    }

    /**
     * Store a preloaded map in a named bucket.
     */
    public static function put(string $bucket, array $map): void
    {
        self::$store[$bucket] = $map;
    }

    /**
     * Retrieve a single preloaded value from a bucket.
     */
    public static function get(string $bucket, $key, $default = null)
    {
        return self::$store[$bucket][$key] ?? $default;
    }

    /**
     * Whether a bucket has been preloaded.
     */
    public static function has(string $bucket): bool
    {
        return isset(self::$store[$bucket]);
    }
}
