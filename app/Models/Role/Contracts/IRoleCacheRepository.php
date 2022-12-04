<?php

namespace App\Models\Role\Contracts;

use App\Models\Common\Contacts\ICacheRepository;

/**
 * Interface IRoleCacheRepository
 * @package App\Models\Role\Contracts
 */
interface IRoleCacheRepository extends IRoleRepository, ICacheRepository
{
    /**
     * Reset cache for getting of all roles
     *
     * @return void
     */
    public function resetAllRolesCache(): void;
}
