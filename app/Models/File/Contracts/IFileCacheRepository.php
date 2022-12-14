<?php

namespace App\Models\File\Contracts;

use App\Models\Common\Contacts\ICacheRepository;
use App\Models\File\DTO\FileDTO;

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

    /**
     * Get file instance by id for specific owner
     *
     * @param int $id
     * @param int $userOwnerId
     * @return FileDTO|null
     */
    public function getFileForOwner(int $id, int $userOwnerId): ?FileDTO;

    /**
     * Reset cache for files by ids
     *
     * @param array $fileIds
     * @return void
     */
    public function resetCacheForFiles(array $fileIds): void;
}
