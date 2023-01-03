<?php

namespace App\Models\File\Contracts;

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
}
