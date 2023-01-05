<?php

namespace App\Models\Link\Contracts;

/**
 * Interface ILinkCacheRepository
 * @package App\Models\Link\Contracts
 */
interface ILinkCacheRepository extends ILinkRepository
{

    /**
     * Reset links cache for specific file
     *
     * @param int $fileId
     * @return void
     */
    public function resetCacheForFile(int $fileId): void;

    /**
     * Reset links cache for files by ids
     *
     * @param array $fileIds
     * @return void
     */
    public function resetCacheForFiles(array $fileIds): void;
}
