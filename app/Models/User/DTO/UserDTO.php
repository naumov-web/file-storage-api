<?php

namespace App\Models\User\DTO;

use App\Models\Common\DTO\ModelDTO;

/**
 * Class UserDTO
 * @package App\Models\User\DTO
 */
final class UserDTO extends ModelDTO
{
    protected $exceptAutoFields = [
        'roles'
    ];

    /**
     * User id value
     * @var int
     */
    public int $id;

    /**
     * User email value
     * @var string
     */
    public string $email;

    /**
     * User password value
     * @var string|null
     */
    public string|null $password;

    /**
     * User name value
     * @var string
     */
    public string $name;

    /**
     * User confirmation code value
     * @var string|null
     */
    public string|null $confirmation_code = null;

    /**
     * Roles list
     * @var array
     */
    public array $roles;
}
