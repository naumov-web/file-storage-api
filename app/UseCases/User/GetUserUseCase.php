<?php

namespace App\UseCases\User;

use App\Models\User\Composers\UserDTOComposer;
use App\Models\User\DTO\UserDTO;
use App\UseCases\BaseUseCase;
use App\UseCases\User\InputDTO\GetUserInputDTO;

/**
 * Class GetUserUseCase
 * @package App\UseCases\User
 */
final class GetUserUseCase extends BaseUseCase
{
    /**
     * User DTO instance
     * @var UserDTO
     */
    private UserDTO $userDto;

    /**
     * GetUserUseCase constructor
     * @param UserDTOComposer $composer
     */
    public function __construct(private UserDTOComposer $composer){}

    /**
     * Get User DTO instance
     *
     * @return UserDTO
     */
    public function getUserDto(): UserDTO
    {
        return $this->userDto;
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return GetUserInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $user = $this->inputDto->user;
        $user->load(['roles']);

        $this->userDto = $this->composer->getFromModel($user);
    }
}
