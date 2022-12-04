<?php

namespace App\Models\Role\Services;

use App\Models\Role\Contracts\IRoleCacheRepository;
use App\Models\Role\Contracts\IRoleDatabaseRepository;
use App\Models\Role\Contracts\IRoleService;
use App\Models\Role\DTO\RoleDTO;
use App\Models\Role\Exceptions\RoleWithNameAlreadyExistsException;
use App\Models\Role\Exceptions\RoleWithSystemNameAlreadyExistsException;

/**
 * Class Service
 * @package App\Models\Role\Services
 */
final class Service implements IRoleService
{
    /**
     * Service constructor
     * @param IRoleCacheRepository $cacheRepository
     * @param IRoleDatabaseRepository $databaseRepository
     */
    public function __construct(
        protected IRoleCacheRepository $cacheRepository,
        protected IRoleDatabaseRepository $databaseRepository
    ) {}

    /**
     * @inheritDoc
     * @param RoleDTO $dto
     * @throws RoleWithNameAlreadyExistsException
     * @throws RoleWithSystemNameAlreadyExistsException
     */
    public function create(RoleDTO $dto): void
    {
        $roles = $this->cacheRepository->getAllRoles();

        foreach ($roles as $role) {
            /**
             * @var RoleDTO $role
             */
            if ($dto->name === $role->name) {
                throw new RoleWithNameAlreadyExistsException();
            }

            if ($dto->system_name && $dto->system_name === $role->system_name) {
                throw new RoleWithSystemNameAlreadyExistsException();
            }
        }

        $this->databaseRepository->create($dto);

        $this->cacheRepository->resetAllRolesCache();
    }
}
