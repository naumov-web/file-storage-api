<?php

namespace App\Models\File\Contracts;

use App\Models\Common\Contacts\ICacheRepository;

/**
 * Interface IFileCacheRepository
 * @package App\Models\File\Contracts
 */
interface IFileCacheRepository extends IFileRepository, ICacheRepository
{
    /**
     * Reset cache for specific user
     *
     * @param int $userOwnerId
     * @return void
     */
    public function resetCacheForUser(int $userOwnerId): void;
}
