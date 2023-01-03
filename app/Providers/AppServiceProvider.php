<?php

namespace App\Providers;

use App\Gateways\Contracts\IFileGatewayInterface;
use App\Gateways\File\LocalGateway;
use App\Models\File\Contracts\IFileService;
use App\Models\Invitation\Contacts\IInvitationService;
use App\Models\Role\Contracts\IRoleCacheRepository;
use App\Models\Role\Contracts\IRoleDatabaseRepository;
use App\Models\Role\Contracts\IRoleRepository;
use App\Models\Role\Contracts\IRoleService;
use App\Models\Role\Repositories\CacheRepository;
use App\Models\Role\Repositories\DatabaseRepository;
use App\Models\Role\Services\Service;
use App\Models\User\Contracts\IUserCacheRepository;
use App\Models\User\Contracts\IUserDatabaseRepository;
use App\Models\User\Contracts\IUserRepository;
use App\Models\User\Contracts\IUserService;
use App\Models\User;
use App\Models\Invitation;
use App\Models\File;
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
        // User
        $this->app->bind(IUserCacheRepository::class, User\Repositories\CacheRepository::class);
        $this->app->bind(IUserDatabaseRepository::class, User\Repositories\DatabaseRepository::class);
        $this->app->bind(IUserRepository::class, User\Repositories\DatabaseRepository::class);
        $this->app->bind(IUserService::class, User\Services\Service::class);
        // Invitation
        $this->app->bind(
            Invitation\Contacts\IInvitationCacheRepository::class,
            Invitation\Repositories\CacheRepository::class
        );
        $this->app->bind(
            Invitation\Contacts\IInvitationDatabaseRepository::class,
            Invitation\Repositories\DatabaseRepository::class
        );
        $this->app->bind(
            Invitation\Contacts\IInvitationRepository::class,
            Invitation\Repositories\DatabaseRepository::class
        );
        $this->app->bind(IInvitationService::class, Invitation\Services\Service::class);
        // File
        $this->app->bind(
            File\Contracts\IFileCacheRepository::class,
            File\Repositories\CacheRepository::class
        );
        $this->app->bind(
            File\Contracts\IFileDatabaseRepository::class,
            File\Repositories\DatabaseRepository::class
        );
        $this->app->bind(
            File\Contracts\IFileRepository::class,
            File\Repositories\DatabaseRepository::class
        );
        $this->app->bind(IFileService::class, File\Service\Service::class);
        // Gateways
        $this->app->bind(IFileGatewayInterface::class, LocalGateway::class);
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
