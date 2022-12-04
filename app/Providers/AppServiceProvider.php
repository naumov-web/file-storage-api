<?php

namespace App\Providers;

use App\Models\Role\Contracts\IRoleCacheRepository;
use App\Models\Role\Contracts\IRoleDatabaseRepository;
use App\Models\Role\Contracts\IRoleRepository;
use App\Models\Role\Contracts\IRoleService;
use App\Models\Role\Repositories\CacheRepository;
use App\Models\Role\Repositories\DatabaseRepository;
use App\Models\Role\Services\Service;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Role
        $this->app->bind(IRoleCacheRepository::class, CacheRepository::class);
        $this->app->bind(IRoleDatabaseRepository::class, DatabaseRepository::class);
        $this->app->bind(IRoleRepository::class, DatabaseRepository::class);
        $this->app->bind(IRoleService::class, Service::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
