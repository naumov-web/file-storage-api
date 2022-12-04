<?php

namespace App\Models\Role\Repositories;

use App\Models\Role\Composers\RoleDTOComposer;
use App\Models\Role\Contracts\IRoleCacheRepository;
use App\Models\Role\Contracts\IRoleRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheRepository
 * @package App\Models\Role\Repositories
 */
final class CacheRepository implements IRoleCacheRepository
{
    /**
     * Database role repository instance
     * @var IRoleRepository
     */
    protected $databaseRepository;

    /**
     * CacheRepository constructor
     * @param IRoleRepository $databaseRepository
     */
    public function __construct(IRoleRepository $databaseRepository)
    {
        $this->databaseRepository = $databaseRepository;
    }

    /**
     * @inheritDoc
     */
    public function getVersionNumber(): string
    {
        return '1';
    }

    /**
     * @inheritDoc
     */
    public function getDirectoryKey(): string
    {
        return 'roles/v' . $this->getVersionNumber();
    }

    /**
     * Get all roles collection
     *
     * @return Collection
     */
    public function getAllRoles(): Collection
    {
        $keyName = $this->getDirectoryKey() . '/index';
        $items = Cache::get($keyName);

        if ($items) {
            return $items;
        } else {
            $items = $this->databaseRepository->getAllRoles();
            Cache::put(
                $keyName,
                $items
            );

            return $items;
        }
    }

    /**
     * @inheritDoc
     */
    public function resetAllRolesCache(): void
    {
        $keyName = $this->getDirectoryKey() . '/index';
        Cache::forget($keyName);
    }
}
