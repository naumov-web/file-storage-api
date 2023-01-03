<?php

namespace App\UseCases\File\InputDTO;

use App\UseCases\Common\DTO\BaseUseCaseDTO;

/**
 * Class DeleteUserFileInputDTO
 * @package App\UseCases\File\InputDTO
 */
final class DeleteUserFileInputDTO extends BaseUseCaseDTO
{
    /**
     * File id value
     * @var int
     */
    public int $id;

    /**
     * User owner id value
     * @var int
     */
    public int $userOwnerId;
}
