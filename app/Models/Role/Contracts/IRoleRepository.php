<?php

namespace App\Models\Role\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface IRoleRepository
 * @package App\Models\Role\Contracts
 */
interface IRoleRepository
{
    /**
     * Get all roles collection
     *
     * @return Collection
     */
    public function getAllRoles(): Collection;
}
