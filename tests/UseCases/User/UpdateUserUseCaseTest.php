<?php

namespace Tests\UseCases\User;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\User\Model;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\User\AuthorizeUserUseCase;
use App\UseCases\User\InputDTO\AuthorizeUserInputDTO;
use App\UseCases\User\InputDTO\CreateUserInputDTO;
use App\UseCases\User\InputDTO\UpdateUserInputDTO;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCases\BaseUseCaseTest;

/**
 * Class UpdateUserUseCaseTest
 * @package Tests\UseCase\User
 */
final class UpdateUserUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test case when we update only user's name
     *
     * @test
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testCaseWhenWeUpdateOnlyName(): void
    {
        $this->createRoles();

        $createUserInputDto = new CreateUserInputDTO();
        $createUserInputDto->email = 'user1@email.com';
        $createUserInputDto->name = 'User one';
        $createUserInputDto->password = 'password';
        $createUserInputDto->roleSystemNames = 'user';

        $createUserUseCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_USER);
        $createUserUseCase->setInputDTO($createUserInputDto);
        $createUserUseCase->execute();

        /**
         * @var Model $user
         */
        $user = Model::query()
            ->where('email', $createUserInputDto->email)
            ->first();

        $updateUserInputDto = new UpdateUserInputDTO();
        $updateUserInputDto->name = 'User two';
        $updateUserInputDto->user = $user;

        $updateUserUseCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::UPDATE_USER);
        $updateUserUseCase->setInputDTO($updateUserInputDto);
        $updateUserUseCase->execute();

        $user->refresh();

        $this->assertEquals(
            $updateUserInputDto->name,
            $user->name
        );
    }

    /**
     * Test case when we change user's name and password
     *
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenWeChangeNameAndPassword(): void
    {
        $this->createRoles();

        $createUserInputDto = new CreateUserInputDTO();
        $createUserInputDto->email = 'user1@email.com';
        $createUserInputDto->name = 'User one';
        $createUserInputDto->password = 'password';
        $createUserInputDto->roleSystemNames = 'user';

        $createUserUseCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_USER);
        $createUserUseCase->setInputDTO($createUserInputDto);
        $createUserUseCase->execute();

        /**
         * @var Model $user
         */
        $user = Model::query()
            ->where('email', $createUserInputDto->email)
            ->first();

        $updateUserInputDto = new UpdateUserInputDTO();
        $updateUserInputDto->name = 'User two';
        $updateUserInputDto->password = 'password2';
        $updateUserInputDto->user = $user;

        $updateUserUseCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::UPDATE_USER);
        $updateUserUseCase->setInputDTO($updateUserInputDto);
        $updateUserUseCase->execute();

        $authorizeUserInputDto = new AuthorizeUserInputDTO();
        $authorizeUserInputDto->email = $createUserInputDto->email;
        $authorizeUserInputDto->password = $createUserInputDto->password;

        $this->expectException(AuthorizationException::class);

        /**
         * @var AuthorizeUserUseCase $authorizeUserUseCase
         */
        $authorizeUserUseCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::AUTHORIZE_USER);
        $authorizeUserUseCase->setInputDTO($authorizeUserInputDto);
        $authorizeUserUseCase->execute();

        $authorizeUserInputDto->password = $updateUserInputDto->password;

        $authorizeUserUseCase->setInputDTO($authorizeUserInputDto);
        $authorizeUserUseCase->execute();

        $this->assertNotNull($authorizeUserUseCase->getToken());
    }
}
