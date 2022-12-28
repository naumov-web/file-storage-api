<?php

namespace App\Models\User\Repositories;

use App\Models\Common\Repositories\BaseDatabaseRepository;
use App\Models\User\Composers\UserDTOComposer;
use App\Models\User\Contracts\IUserDatabaseRepository;
use App\Models\User\DTO\UserDTO;
use App\Models\User\Exceptions\UserDoesntExistException;
use App\Models\User\Model;

/**
 * Class DatabaseRepository
 * @package App\Models\User\Repositories
 */
final class DatabaseRepository extends BaseDatabaseRepository implements IUserDatabaseRepository
{
    /**
     * DatabaseRepository constructor
     * @param UserDTOComposer $composer
     */
    public function __construct(private UserDTOComposer $composer)
    {
    }

    /**
     * @inheritDoc
     */
    protected function getModelsClass(): string
    {
        return Model::class;
    }

    /**
     * @inheritDoc
     */
    public function getUserByEmail(string $email): ?UserDTO
    {
        $query = $this->getQuery();
        $query->where('email', $email);
        /**
         * @var Model $model
         */
        $model = $query->first();

        if (!$model) {
            return null;
        }

        /**
         * @var UserDTO $dto
         */
        $dto = $this->composer->getFromModel($model);

        return $dto;
    }

    /**
     * @inheritDoc
     */
    public function createUser(UserDTO $dto): UserDTO
    {
        /**
         * @var Model $model
         */
        $model = Model::query()->create([
            'email' => $dto->email,
            'name' => $dto->name,
            'password' => $dto->password,
            'confirmation_code' => $dto->confirmation_code
        ]);

        $dto->id = $model->id;

        return $dto;
    }

    /**
     * @inheritDoc
     */
    public function syncUserRoles(UserDTO $dto, array $roleIds): void
    {
        /**
         * @var Model|null $user
         */
        $user = Model::query()->find($dto->id);

        if (!$user) {
            throw new UserDoesntExistException();
        }

        $user->roles()->sync($roleIds);
    }

    /**
     * @inheritDoc
     */
    public function updateUser(int $userId, UserDTO $dto): UserDTO
    {
        $model = Model::query()->find($userId);
        $newData = [
            'name' => $dto->name
        ];

        if ($dto->password) {
            $newData['password'] = $dto->password;
        }

        $model->update($newData);

        return $dto;
    }
}
