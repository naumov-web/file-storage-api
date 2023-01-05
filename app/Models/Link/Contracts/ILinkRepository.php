<?php

namespace App\Models\Link\Contracts;

use App\Models\Link\DTO\LinkDTO;
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

    /**
     * Get link by code
     *
     * @param string $code
     * @return LinkDTO|null
     */
    public function getLinkByCode(string $code): ?LinkDTO;
}
