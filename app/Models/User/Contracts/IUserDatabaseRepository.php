<?php

namespace App\Models\User\Contracts;

use App\Models\User\DTO\UserDTO;

/**
 * Interface IRoleDatabaseRepository
 * @package App\Models\User\Contracts
 */
interface IUserDatabaseRepository extends IUserRepository
{
    /**
     * Create user in database
     *
     * @param UserDTO $dto
     * @return UserDTO
     */
    public function createUser(UserDTO $dto): UserDTO;

    /**
     * Sync roles for specific user
     *
     * @param UserDTO $dto
     * @param array $roleIds
     * @return void
     */
    public function syncUserRoles(UserDTO $dto, array $roleIds): void;

    /**
     * Update specific user instance
     *
     * @param int $userId
     * @param UserDTO $dto
     * @return UserDTO
     */
    public function updateUser(int $userId, UserDTO $dto): UserDTO;
}
