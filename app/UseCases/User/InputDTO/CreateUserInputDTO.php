<?php

namespace App\UseCases\User\InputDTO;

use App\UseCases\Common\DTO\BaseUseCaseDTO;

/**
 * Class CreateUserInputDTO
 * @package App\UseCases\User\InputDTO
 */
final class CreateUserInputDTO extends BaseUseCaseDTO
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

    /**
     * Name value
     * @var string
     */
    public string $name;

    /**
     * Role system names
     * @var string
     */
    public string $roleSystemNames;

    /**
     * Auto confirm flag
     * @var bool
     */
    public bool $autoConfirm = false;
}
