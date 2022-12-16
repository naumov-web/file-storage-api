<?php

namespace App\UseCases\User;

use App\Models\Role\Contracts\IRoleCacheRepository;
use App\Models\Role\DTO\RoleDTO;
use App\Models\User\Contracts\IUserService;
use App\Models\User\DTO\UserDTO;
use App\UseCases\BaseUseCase;
use App\UseCases\User\InputDTO\CreateUserInputDTO;

/**
 * Class CreateUserUseCase
 * @package App\UseCases\User
 */
final class CreateUserUseCase extends BaseUseCase
{
    /**
     * CreateUserUseCase constructor
     * @param IUserService $service
     */
    public function __construct(private IUserService $service, private IRoleCacheRepository $roleRepository)
    {
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return CreateUserInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        /**
         * @var CreateUserInputDTO $inputDto
         */
        $inputDto = $this->inputDto;
        $dto = new UserDTO();
        $dto->email = $inputDto->email;
        $dto->name = $inputDto->name;
        $dto->password = $inputDto->password;

        $userDto = $this->service->createUser(
            $dto,
            $inputDto->autoConfirm
        );
        $this->syncRoles($userDto);
    }

    /**
     * Attach roles to specific user
     *
     * @param UserDTO $userDto
     * @return void
     */
    private function syncRoles(UserDTO $userDto): void
    {
        /**
         * @var CreateUserInputDTO $inputDto
         */
        $inputDto = $this->inputDto;
        $systemNames = explode(
            ',',
            $inputDto->roleSystemNames
        );
        $roles = $this->roleRepository->getAllRoles();
        $userRoleIds = [];

        foreach ($roles as $role) {
            /**
             * @var RoleDTO $role
             */
            if (in_array($role->system_name, $systemNames)) {
                $userRoleIds[] = $role->id;
            }
        }

        $this->service->syncUserRoles(
            $userDto,
            $userRoleIds
        );
    }
}
