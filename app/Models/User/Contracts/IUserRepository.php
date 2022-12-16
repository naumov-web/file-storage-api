<?php

namespace App\Models\User\Contracts;

use App\Models\User\DTO\UserDTO;

/**
 * Interface IUserRepository
 * @package App\Models\User\Contracts
 */
interface IUserRepository
{
    /**
     * Get user DTO instance by email
     *
     * @param string $email
     * @return UserDTO|null
     */
    public function getUserByEmail(string $email): ?UserDTO;
}
