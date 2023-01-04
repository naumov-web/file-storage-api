<?php

namespace Tests\UseCases\File;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\User;
use App\Models\File;
use App\UseCases\Common\DTO\FileDTO;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\File\InputDTO\CreateUserFileInputDTO;
use App\UseCases\File\InputDTO\DeleteUserFileInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCases\BaseUseCaseTest;

/**
 * Class DeleteUserFileUseCaseTest
 * @package Tests\UseCases\File
 */
final class DeleteUserFileUseCaseTest extends BaseUseCaseTest
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
        /**
         * @var User\Model $user
         */
        $user = User\Model::query()->create([
            'email' => 'user1@email.com',
            'password' => 'password',
            'name' => 'User 1'
        ]);

        $createUserFileInputDto = new CreateUserFileInputDTO();
        $createUserFileInputDto->user = $user;
        $createUserFileInputDto->file = new FileDTO();
        $createUserFileInputDto->file->name = '0001.png';
        $createUserFileInputDto->file->mime = 'image/png';
        $createUserFileInputDto->file->content = base64_encode(
            file_get_contents(
                base_path(
                    'tests/resources/files/001.png'
                )
            )
        );

        $createUserFileUseCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::CREATE_USER_FILE);
        $createUserFileUseCase->setInputDTO($createUserFileInputDto);
        $createUserFileUseCase->execute();

        /**
         * @var File\Model $file
         */
        $file = File\Model::query()
            ->where('user_owner_id', $user->id)
            ->where('name', $createUserFileInputDto->file->name)
            ->first();

        $deleteUserFileInputDto = new DeleteUserFileInputDTO();
        $deleteUserFileInputDto->id = $file->id;
        $deleteUserFileInputDto->userOwnerId = $user->id;

        $deleteUseFileUseCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::DELETE_USER_FILE);
        $deleteUseFileUseCase->setInputDTO($deleteUserFileInputDto);
        $deleteUseFileUseCase->execute();

        $this->assertNull(
            File\Model::query()
                ->where('id', $file->id)
                ->first()
        );

        $this->assertEquals(
            0,
            File\Model::query()
                ->where('user_owner_id', $user->id)
                ->count()
        );
    }

    /**
     * Test case, when user tries to file from other user
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenUserTriesToDeleteFileFromOtherUser(): void
    {
        /**
         * @var User\Model $user1
         */
        $user1 = User\Model::query()->create([
            'email' => 'user1@email.com',
            'password' => 'password',
            'name' => 'User 1'
        ]);

        $createUserFileInputDto = new CreateUserFileInputDTO();
        $createUserFileInputDto->user = $user1;
        $createUserFileInputDto->file = new FileDTO();
        $createUserFileInputDto->file->name = '0001.png';
        $createUserFileInputDto->file->mime = 'image/png';
        $createUserFileInputDto->file->content = base64_encode(
            file_get_contents(
                base_path(
                    'tests/resources/files/001.png'
                )
            )
        );

        $createUserFileUseCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::CREATE_USER_FILE);
        $createUserFileUseCase->setInputDTO($createUserFileInputDto);
        $createUserFileUseCase->execute();

        /**
         * @var File\Model $file
         */
        $file = File\Model::query()
            ->where('user_owner_id', $user1->id)
            ->where('name', $createUserFileInputDto->file->name)
            ->first();

        /**
         * @var User\Model $user2
         */
        $user2 = User\Model::query()->create([
            'email' => 'user2@email.com',
            'password' => 'password',
            'name' => 'User 2'
        ]);

        $deleteUserFileInputDto = new DeleteUserFileInputDTO();
        $deleteUserFileInputDto->id = $file->id;
        $deleteUserFileInputDto->userOwnerId = $user2->id;

        $this->expectException(File\Exceptions\FileForbiddenException::class);

        $deleteUseFileUseCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::DELETE_USER_FILE);
        $deleteUseFileUseCase->setInputDTO($deleteUserFileInputDto);
        $deleteUseFileUseCase->execute();

        $this->removeTempFile($file->path);
    }

    /**
     * Remove temp file
     *
     * @param string $filePath
     * @return void
     */
    private function removeTempFile(string $filePath): void
    {
        @unlink(storage_path($filePath));
    }
}
