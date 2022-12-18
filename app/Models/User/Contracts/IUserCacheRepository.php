<?php

namespace App\Models\User\Contracts;

use App\Models\Common\Contacts\ICacheRepository;

/**
 * Interface IUserCacheRepository
 * @package App\Models\User\Contracts
 */
interface IUserCacheRepository extends IUserRepository, ICacheRepository
{
}
