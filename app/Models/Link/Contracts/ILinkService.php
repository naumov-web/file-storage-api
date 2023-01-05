<?php

namespace App\Models\Link\Contracts;

use App\Models\Link\DTO\LinkDTO;

/**
 * Interface ILinkService
 * @package App\Models\Link\Contracts
 */
interface ILinkService
{
    /**
     * Create link instance
     *
     * @param LinkDTO $dto
     * @return LinkDTO
     */
    public function create(LinkDTO $dto): LinkDTO;

    /**
     * Remove expired temporary links
     *
     * @return array
     */
    public function removeExpiredTemporaryLinks(): array;

    /**
     * Get link by code
     *
     * @param string $code
     * @return LinkDTO
     */
    public function getLinkByCode(string $code): LinkDTO;

    /**
     * Increment opens count for link instance
     *
     * @param LinkDTO $dto
     * @return void
     */
    public function incrementOpensCount(LinkDTO $dto): void;
}
