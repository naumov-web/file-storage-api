<?php

namespace App\UseCases\File\InputDTO;

use App\Models\User\Model;
use App\UseCases\Common\DTO\BaseListUseCaseDTO;

/**
 * Class GetUserFilesInputDTO
 * @package App\UseCases\File\InputDTO
 */
final class GetUserFilesInputDTO extends BaseListUseCaseDTO
{
    /**
     * User model instance
     * @var Model
     */
    public Model $user;
}
