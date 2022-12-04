<?php

namespace App\Models\Role\Contracts;

use App\Models\Role\DTO\RoleDTO;

/**
 * Interface IRoleService
 * @package App\Models\Role\Contracts
 */
interface IRoleService
{
    /**
     * Create role instance
     *
     * @param RoleDTO $dto
     * @return void
     */
    public function create(RoleDTO $dto): void;
}
