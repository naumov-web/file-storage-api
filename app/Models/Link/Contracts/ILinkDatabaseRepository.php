<?php

namespace App\Models\Link\Contracts;

use App\Models\Link\DTO\LinkDTO;

/**
 * Interface ILinkDatabaseRepository
 * @package App\Models\Link\Contracts
 */
interface ILinkDatabaseRepository extends ILinkRepository
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
}
