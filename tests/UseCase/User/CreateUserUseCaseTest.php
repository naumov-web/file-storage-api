<?php

namespace Tests\UseCase\User;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\User\Exceptions\UserWithEmailAlreadyExistsException;
use App\Models\User\Model;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\User\InputDTO\CreateUserInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class CreateUserUseCaseTest
 * @package Tests\UseCase\User
 */
final class CreateUserUseCaseTest extends BaseUseCaseTest
{
    /**
     * Roles data list
     * @var array
     */
    protected $rolesData = [
        [
            'name' => 'Admin',
            'system_name' => 'admin'
        ],
        [
            'name' => 'User',
            'system_name' => 'user'
        ]
    ];

    /**
     * Test case, when we try to create user, but other user with this email already exists
     *
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testCaseWhenWeTryToCreateUserButUserWithThisEmailAlreadyExists(): void
    {
        $userData = [
            'email' => 'user1@email.com',
            'password' => 'password',
            'name' => 'User',
        ];
        Model::query()->create($userData);

        $inputDto = new CreateUserInputDTO();
        $inputDto->email = $userData['email'];
        $inputDto->password = $userData['password'];
        $inputDto->name = $userData['name'];
        $inputDto->autoConfirm = true;

        $this->expectException(UserWithEmailAlreadyExistsException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_USER);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertEquals(
            1,
            Model::query()->where('email', $userData['email'])->count()
        );
    }

    /**
     * Test case when we try to create new user
     *
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenWeTryToCreateUser(): void
    {
        $this->createRoles();

        $inputDto = new CreateUserInputDTO();
        $inputDto->email = 'user1@email.com';
        $inputDto->password = 'password';
        $inputDto->name = 'User';
        $inputDto->autoConfirm = true;
        $inputDto->roleSystemNames = 'admin,user';

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_USER);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        /**
         * @var Model $userModel
         */
        $userModel = Model::query()
            ->where('email', $inputDto->email)
            ->where('name', $inputDto->name)
            ->first();
        $this->assertNotNull($userModel);

        $this->assertEquals(
            2,
            $userModel->roles()->count()
        );

        $systemNames = explode(
            ',',
            $inputDto->roleSystemNames
        );

        foreach ($userModel->roles as $role) {
            /**
             * @var \App\Models\Role\Model $role
             */
            $this->assertTrue(
                in_array(
                    $role->system_name,
                    $systemNames
                )
            );
        }
    }

    /**
     * Create roles
     *
     * @return void
     */
    private function createRoles(): void
    {
        foreach ($this->rolesData as $roleData) {
            \App\Models\Role\Model::query()->create($roleData);
        }
    }
}
