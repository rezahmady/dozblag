<?php

namespace App\Services\Modules;

use Illuminate\Cache\CacheManager;
use Illuminate\Config\Repository as Config;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Nwidart\Modules\Contracts\ActivatorInterface;
use Nwidart\Modules\Module;

class DatabaseActivator implements ActivatorInterface
{
    /**
     * Laravel cache instance
     *
     * @var CacheManager
     */
    private $cache;

    /**
     * Laravel config instance
     *
     * @var Config
     */
    private $config;

    /**
     * @var string
     */
    private $cacheKey;

    /**
     * @var string
     */
    private $cacheLifetime;

    /**
     * Array of modules activation statuses
     *
     * @var array
     */
    private $modulesStatuses;

    private $table = 'modules';

    public function __construct(Container $app)
    {
        $this->cache = $app['cache'];
        $this->config = $app['config'];
        $this->statusesFile = $this->config('statuses-file');
        $this->cacheKey = $this->config('cache-key');
        $this->cacheLifetime = $this->config('cache-lifetime');
        $this->modulesStatuses = $this->getModulesStatuses();
        $this->table = $this->config('table_name');
    }

    /**
     * @inheritDoc
     */
    public function reset(): void
    {
        DB::table($this->table)->truncate();
        $this->modulesStatuses = [];
        $this->flushCache();
    }

    /**
     * @inheritDoc
     */
    public function enable(Module $module): void
    {
        $this->setActiveByName($module->getName(), true);
    }

    /**
     * @inheritDoc
     */
    public function disable(Module $module): void
    {
        $this->setActiveByName($module->getName(), false);
    }

    /**
     * @inheritDoc
     */
    public function hasStatus(Module $module, bool $status): bool
    {
        if (!isset($this->modulesStatuses[$module->getName()])) {
            return $status === false;
        }

        return $this->modulesStatuses[$module->getName()] === $status;
    }

    /**
     * @inheritDoc
     */
    public function setActive(Module $module, bool $active): void
    {
        $this->setActiveByName($module->getName(), $active);
    }

    /**
     * @inheritDoc
     */
    public function setActiveByName(string $name, bool $status): void
    {
        $this->modulesStatuses[$name] = $status;
        DB::table($this->table)->where('name',$name)->update(['status' => $status]);
        $this->flushCache();
    }

    /**
     * @inheritDoc
     */
    public function delete(Module $module): void
    {
        if (!isset($this->modulesStatuses[$module->getName()])) {
            return;
        }
        unset($this->modulesStatuses[$module->getName()]);
        DB::table($this->table)->where('name',$module->getName())->delete();
        $this->flushCache();
    }

    /**
     * Reads the database that contains the activation statuses.
     * @return array
     */
    private function readDatabase(): array
    {
        if(Schema::hasTable($this->table)) {
            return DB::table($this->table)->pluck('status', 'name')->toArray();
        } else {
            return [];
        }
    }

    /**
     * Get modules statuses, either from the cache or from
     * the database if the cache is disabled.
     * @return array
     */
    private function getModulesStatuses(): array
    {
        if (!$this->config->get('modules.cache.enabled')) {
            return $this->readDatabase();
        }

        return $this->cache->remember($this->cacheKey, $this->cacheLifetime, function () {
            return $this->readDatabase();
        });
    }

    /**
     * Reads a config parameter under the 'activators.database' key
     *
     * @param  string $key
     * @param  $default
     * @return mixed
     */
    private function config(string $key, $default = null)
    {
        return $this->config->get('modules.activators.database.' . $key, $default);
    }

    /**
     * Flushes the modules activation statuses cache
     */
    private function flushCache(): void
    {
        $this->cache->forget($this->cacheKey);
    }
}
