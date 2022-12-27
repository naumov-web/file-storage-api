<?php

namespace Tests\UseCase\User;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\Role\DTO\RoleDTO;
use App\Models\User\Model;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\User\GetUserUseCase;
use App\UseCases\User\InputDTO\CreateUserInputDTO;
use App\UseCases\User\InputDTO\GetUserInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class GetUserUseCaseTest
 * @package Tests\UseCase\User
 */
final class GetUserUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test success case
     *
     * @test
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testSuccessCase(): void
    {
        $this->createRoles();
        $roleSystemNames = [
            'admin',
            'user'
        ];

        $createUserInputDto = new CreateUserInputDTO();
        $createUserInputDto->email = 'email1@email.com';
        $createUserInputDto->password = 'password';
        $createUserInputDto->name = 'User';
        $createUserInputDto->roleSystemNames = implode(
            ',',
            $roleSystemNames
        );

        $createUserUseCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_USER);
        $createUserUseCase->setInputDTO($createUserInputDto);
        $createUserUseCase->execute();

        /**
         * @var Model $user
         */
        $user = Model::query()
            ->where('email', $createUserInputDto->email)
            ->first();

        $getUserInputDto = new GetUserInputDTO();
        $getUserInputDto->user = $user;

        /**
         * @var GetUserUseCase $getUserUseCase
         */
        $getUserUseCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_USER);
        $getUserUseCase->setInputDTO($getUserInputDto);
        $getUserUseCase->execute();

        $userDto = $getUserUseCase->getUserDto();

        $this->assertEquals(
            $createUserInputDto->email,
            $userDto->email
        );
        $this->assertEquals(
            $createUserInputDto->name,
            $userDto->name
        );
        $this->assertCount(
            2,
            $userDto->roles
        );

        foreach ($userDto->roles as $role) {
            /**
             * @var RoleDTO $role
             */
            $this->assertTrue(
                in_array(
                    $role->system_name,
                    $roleSystemNames
                )
            );
        }
    }
}
