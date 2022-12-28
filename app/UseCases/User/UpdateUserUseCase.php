<?php

namespace App\UseCases\User;

use App\Models\User\Contracts\IUserService;
use App\Models\User\DTO\UserDTO;
use App\UseCases\BaseUseCase;
use App\UseCases\User\InputDTO\UpdateUserInputDTO;

/**
 * Class UpdateUserUseCase
 * @package App\UseCases\User
 */
final class UpdateUserUseCase extends BaseUseCase
{
    /**
     * UpdateUserUseCase constructor
     * @param IUserService $service
     */
    public function __construct(private IUserService $service) {}

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return UpdateUserInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $dto = new UserDTO();
        $dto->id = $this->inputDto->user->id;
        $dto->name = $this->inputDto->name;
        $dto->password = $this->inputDto->password ?? null;

        $this->service->updateUser($dto);
    }
}
