<?php

namespace App\UseCases\User\InputDTO;

use App\Models\User\Model;
use App\UseCases\Common\DTO\BaseUseCaseDTO;

/**
 * Class UpdateUserInputDTO
 * @package App\UseCases\User\InputDTO
 */
final class UpdateUserInputDTO extends BaseUseCaseDTO
{
    /**
     * User model instance
     * @var Model
     */
    public Model $user;

    /**
     * Name value
     * @var string
     */
    public string $name;

    /**
     * Password value
     * @var string|null
     */
    public string|null $password;
}
