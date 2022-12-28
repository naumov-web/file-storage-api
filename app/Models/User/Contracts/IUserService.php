<?php

namespace App\Models\User\Contracts;

use App\Models\User\DTO\UserDTO;

/**
 * Interface IUserService
 * @package App\Models\User\Contracts
 */
interface IUserService
{
    /**
     * Create user instance
     *
     * @param UserDTO $dto
     * @param bool $isAutoConfirm
     * @return UserDTO
     */
    public function createUser(UserDTO $dto, bool $isAutoConfirm): UserDTO;

    /**
     * Sync roles for specific user
     *
     * @param UserDTO $dto
     * @param array $roleIds
     * @return void
     */
    public function syncUserRoles(UserDTO $dto, array $roleIds): void;

    /**
     * Update user instance
     *
     * @param UserDTO $dto
     * @return void
     */
    public function updateUser(UserDTO $dto): void;
}
