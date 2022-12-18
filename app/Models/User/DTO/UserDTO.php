<?php

namespace App\Models\User\DTO;

use App\Models\Common\DTO\ModelDTO;

/**
 * Class UserDTO
 * @package App\Models\User\DTO
 */
final class UserDTO extends ModelDTO
{
    /**
     * User id value
     * @var int
     */
    public $id;

    /**
     * User email value
     * @var string
     */
    public $email;

    /**
     * User password value
     * @var string|null
     */
    public $password;

    /**
     * User name value
     * @var string
     */
    public $name;

    /**
     * User confirmation code value
     * @var string|null
     */
    public $confirmation_code;
}
