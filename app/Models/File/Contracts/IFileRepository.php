<?php

namespace App\Models\File\Contracts;

use App\Models\File\DTO\FileDTO;
use Illuminate\Support\Collection;

/**
 * Interface IFileRepository
 * @package App\Models\File\Contracts
 */
interface IFileRepository
{
    /**
     * Get user files collection
     *
     * @param int $userOwnerId
     * @return Collection
     */
    public function getUserFiles(int $userOwnerId): Collection;

    /**
     * Get file by id
     *
     * @param int $fileId
     * @return FileDTO|null
     */
    public function getFile(int $fileId): ?FileDTO;
}
