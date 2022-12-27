<?php

namespace App\UseCases\User\InputDTO;

use App\Models\User\Model;
use App\UseCases\Common\DTO\BaseUseCaseDTO;

/**
 * Class GetUserInputDTO
 * @package App\UseCases\User\InputDTO
 */
final class GetUserInputDTO extends BaseUseCaseDTO
{
    /**
     * User model instance
     * @var Model
     */
    public Model $user;
}
