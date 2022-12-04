<?php

namespace App\Models\Role\Contracts;

use App\Models\Role\DTO\RoleDTO;

/**
 * Interface IRoleDatabaseRepository
 * @package
 */
interface IRoleDatabaseRepository extends IRoleRepository
{
    /**
     * Create role instance
     *
     * @param RoleDTO $dto
     * @return mixed
     */
    public function create(RoleDTO $dto): RoleDTO;
}
