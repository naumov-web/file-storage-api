<?php

namespace App\UseCases\Invitation;

use App\Models\Invitation\Contacts\IInvitationService;
use App\Models\Invitation\Exceptions\InvitationExpiredException;
use App\Models\Role\Contracts\IRoleCacheRepository;
use App\Models\Role\DTO\RoleDTO;
use App\Models\User\Contracts\IUserService;
use App\Models\User\DTO\UserDTO;
use App\UseCases\BaseUseCase;
use App\UseCases\Invitation\InputDTO\ConfirmInvitationInputDTO;

/**
 * Class ConfirmInvitationUseCase
 * @package App\UseCases\Invitation
 */
final class ConfirmInvitationUseCase extends BaseUseCase
{
    /**
     * Default user role system name
     * @var string
     */
    const DEFAULT_USER_ROLE_SYSTEM_NAME = 'user';

    /**
     * ConfirmInvitationUseCase constructor
     * @param IInvitationService $invitationService
     * @param IUserService $userService
     * @param IRoleCacheRepository $roleRepository
     */
    public function __construct(
        private IInvitationService $invitationService,
        private IUserService $userService,
        private IRoleCacheRepository $roleRepository
    ) {}

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return ConfirmInvitationInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $invitationDto = $this->invitationService->getInvitation($this->inputDto->code);
        $this->invitationService->setAccepted($invitationDto);

        $userDto = new UserDTO();
        $userDto->email = $invitationDto->email;
        $userDto->password = $invitationDto->password;
        $userDto->name = $invitationDto->name;

        $this->userService->createUser(
            dto: $userDto,
            isAutoConfirm: true,
            encodePassword: false
        );
        $this->syncUserRoles($userDto);
    }

    /**
     * Sync user roles
     *
     * @param UserDTO $dto
     * @return void
     */
    private function syncUserRoles(UserDTO $dto): void
    {
        $roles = $this->roleRepository->getAllRoles();
        $userRoleIds = [];
        $roleSystemNames = [
            self::DEFAULT_USER_ROLE_SYSTEM_NAME
        ];

        foreach ($roles as $role) {
            /**
             * @var RoleDTO $role
             */
            if (in_array($role->systemName, $roleSystemNames)) {
                $userRoleIds[] = $role->id;
            }
        }

        $this->userService->syncUserRoles(
            $dto,
            $userRoleIds
        );
    }
}
