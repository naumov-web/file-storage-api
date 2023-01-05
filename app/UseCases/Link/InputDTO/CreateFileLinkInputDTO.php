<?php

namespace App\UseCases\Link\InputDTO;

use App\UseCases\Common\DTO\BaseUseCaseDTO;

/**
 * Class CreateFileLinkInputDTO
 * @package App\UseCases\Link\InputDTO
 */
final class CreateFileLinkInputDTO extends BaseUseCaseDTO
{
    /**
     * User owner id value
     * @var int
     */
    public int $userOwnerId;

    /**
     * File id value
     * @var int
     */
    public int $fileId;

    /**
     * Type id value
     * @var int
     */
    public int $typeId;

    /**
     * Expired at value
     * @var string|null
     */
    public string|null $expiredAt = null;
}
