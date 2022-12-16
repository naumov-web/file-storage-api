<?php

namespace App\Models\User\Services;

use App\Models\User\Contracts\IUserCacheRepository;
use App\Models\User\Contracts\IUserDatabaseRepository;
use App\Models\User\Contracts\IUserService;
use App\Models\User\DTO\UserDTO;
use App\Models\User\Exceptions\UserDoesntExistException;
use App\Models\User\Exceptions\UserWithEmailAlreadyExistsException;
use Illuminate\Support\Facades\Hash;

/**
 * Class Service
 * @package App\Models\User\Services
 */
final class Service implements IUserService
{
    /**
     * Service constructor
     * @param IUserCacheRepository $cacheRepository
     * @param IUserDatabaseRepository $databaseRepository
     */
    public function __construct(
        private IUserCacheRepository $cacheRepository,
        private IUserDatabaseRepository $databaseRepository
    ) {}

    /**
     * @inheritDoc
     * @throws UserWithEmailAlreadyExistsException
     */
    public function createUser(UserDTO $dto, bool $isAutoConfirm): UserDTO
    {
        $existingModel = $this->cacheRepository->getUserByEmail($dto->email);

        if ($existingModel) {
            throw new UserWithEmailAlreadyExistsException();
        }

        if ($dto->password) {
            $dto->password = Hash::make($dto->password);
        }

        if ($isAutoConfirm) {
            $dto->confirmation_code = null;
        }

        return $this->databaseRepository->createUser($dto);
    }

    /**
     * @inheritDoc
     */
    public function syncUserRoles(UserDTO $dto, array $roleIds): void
    {
        $this->databaseRepository->syncUserRoles(
            $dto,
            $roleIds
        );
    }
}
