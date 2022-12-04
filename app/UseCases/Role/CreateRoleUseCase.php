<?php

namespace App\UseCases\Role;

use App\Models\Role\Contracts\IRoleService;
use App\Models\Role\DTO\RoleDTO;
use App\UseCases\BaseUseCase;
use App\UseCases\Role\InputDTO\CreateRoleInputDTO;

/**
 * Class CreateRoleUseCase
 * @package App\UseCases\Role
 */
final class CreateRoleUseCase extends BaseUseCase
{
    /**
     * CreateRoleUseCase constructor
     * @param IRoleService $roleService
     */
    public function __construct(
        private IRoleService $roleService
    ) {}

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return CreateRoleInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $roleDto = new RoleDTO();
        $roleDto->name = $this->inputDto->name;
        $roleDto->system_name = $this->inputDto->systemName;

        $this->roleService->create($roleDto);
    }
}
