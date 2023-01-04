<?php

namespace App\UseCases\File\InputDTO;

use App\Models\User\Model;
use App\UseCases\Common\DTO\BaseUseCaseDTO;
use App\UseCases\Common\DTO\FileDTO;

/**
 * Class CreateUserFileInputDTO
 * @package App\UseCases\File\InputDTO
 */
final class CreateUserFileInputDTO extends BaseUseCaseDTO
{
    /**
     * User model instance
     * @var Model
     */
    public Model $user;

    /**
     * File DTO instance
     * @var FileDTO
     */
    public FileDTO $file;

    /**
     * File description value
     * @var string|null
     */
    public string|null $description = null;
}
