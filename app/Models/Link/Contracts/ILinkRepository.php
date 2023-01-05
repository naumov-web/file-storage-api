<?php

namespace App\Models\Link\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface ILinkRepository
 * @package App\Models\Link\Contracts
 */
interface ILinkRepository
{
    /**
     * Get links by file id
     *
     * @param int $fileId
     * @return Collection
     */
    public function getLinks(int $fileId): Collection;
}
