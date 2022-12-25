<?php

namespace App\UseCases\User\InputDTO;

use App\UseCases\Common\DTO\BaseUseCaseDTO;

/**
 * Class AuthorizeUserInputDTO
 * @package App\UseCases\User\InputDTO
 */
final class AuthorizeUserInputDTO extends BaseUseCaseDTO
{
    /**
     * Email value
     * @var string
     */
    public string $email;

    /**
     * Password value
     * @var string
     */
    public string $password;
}
