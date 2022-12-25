<?php

namespace Tests\UseCase\User;

use App\Enums\UseCaseSystemNamesEnum;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\User\AuthorizeUserUseCase;
use App\UseCases\User\InputDTO\AuthorizeUserInputDTO;
use App\UseCases\User\InputDTO\CreateUserInputDTO;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCase\BaseUseCaseTest;

/**
 * Class AuthorizeUserUseCaseTest
 * @package Tests\UseCase\User
 */
final class AuthorizeUserUseCaseTest extends BaseUseCaseTest
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
     * Test case, when we use incorrect email or password
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenWeUseIncorrectEmailOrPassword(): void
    {
        $inputDto = new AuthorizeUserInputDTO();
        $inputDto->email = 'user1@email.com';
        $inputDto->password = 'password';

        $this->expectException(AuthorizationException::class);

        $authorizeUserUseCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::AUTHORIZE_USER);
        $authorizeUserUseCase->setInputDTO($inputDto);
        $authorizeUserUseCase->execute();
    }

    /**
     * Test case, when we use correct email and password
     *
     * @test
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     * @throws AuthorizationException
     */
    public function testSuccessfullAuthorization(): void
    {
        // Step 1. Create user with roles
        $this->createRoles();

        $createUserInputDto = new CreateUserInputDTO();
        $createUserInputDto->email = 'user1@email.com';
        $createUserInputDto->password = 'password';
        $createUserInputDto->name = 'User';
        $createUserInputDto->autoConfirm = true;
        $createUserInputDto->roleSystemNames = 'admin,user';

        $createUserUseCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_USER);
        $createUserUseCase->setInputDTO($createUserInputDto);
        $createUserUseCase->execute();

        // Step 2. Authorize user
        $authorizeUserInputDto = new AuthorizeUserInputDTO();
        $authorizeUserInputDto->email = $createUserInputDto->email;
        $authorizeUserInputDto->password = $createUserInputDto->password;

        /**
         * @var AuthorizeUserUseCase $authorizeUserUseCase
         */
        $authorizeUserUseCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::AUTHORIZE_USER);
        $authorizeUserUseCase->setInputDTO($authorizeUserInputDto);
        $authorizeUserUseCase->execute();

        $this->assertNotNull($authorizeUserUseCase->getToken());
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
