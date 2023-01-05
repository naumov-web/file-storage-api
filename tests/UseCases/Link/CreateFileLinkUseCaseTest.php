<?php

namespace Tests\UseCases\Link;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\File;
use App\Models\Link\Enums\TypesEnum;
use App\Models\Link\Exceptions\FileForbiddenException;
use App\Models\Link\Exceptions\PermanentLinkAlreadyExistsException;
use App\Models\Link\Model;
use App\Models\User;
use App\UseCases\Common\DTO\FileDTO;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\File\InputDTO\CreateUserFileInputDTO;
use App\UseCases\Link\InputDTO\CreateFileLinkInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCases\BaseUseCaseTest;

/**
 * Class CreateFileLinkUseCaseTest
 * @package Tests\UseCases\Link
 */
final class CreateFileLinkUseCaseTest extends BaseUseCaseTest
{
    /**
     * File name value
     * @var string
     */
    const FILE_NAME = '0001.png';

    /**
     * Test case, when we try to create temporary link
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCreationOfTemporaryLink(): void
    {
        /**
         * @var User\Model $user
         */
        $user = User\Model::query()->create([
            'email' => 'user1@email.com',
            'password' => 'password',
            'name' => 'User 1'
        ]);

        $this->createFile($user);

        /**
         * @var File\Model $file
         */
        $file = File\Model::query()
            ->where('user_owner_id', $user->id)
            ->where('name', self::FILE_NAME)
            ->first();

        $createFileLinkInputDto = new CreateFileLinkInputDTO();
        $createFileLinkInputDto->fileId = $file->id;
        $createFileLinkInputDto->userOwnerId = $user->id;
        $createFileLinkInputDto->typeId = TypesEnum::TEMPORARY;
        $createFileLinkInputDto->expiredAt = date('Y-m-d H:i:s', time() + 3600);

        $createFileLinkUseCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::CREATE_FILE_LINK);
        $createFileLinkUseCase->setInputDTO($createFileLinkInputDto);
        $createFileLinkUseCase->execute();

        $this->assertNotNull(
            Model::query()
                ->where('file_id', $createFileLinkInputDto->fileId)
                ->where('type_id', $createFileLinkInputDto->typeId)
                ->where('expired_at', $createFileLinkInputDto->expiredAt)
                ->whereNotNull('code')
                ->where('is_enabled', true)
                ->where('opens_count', 0)
                ->first()
        );

        $this->removeTempFile($file->path);
    }

    /**
     * Test case, when we try to create permanent link
     *
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCreationOfPermanentLink(): void
    {
        /**
         * @var User\Model $user
         */
        $user = User\Model::query()->create([
            'email' => 'user1@email.com',
            'password' => 'password',
            'name' => 'User 1'
        ]);

        $this->createFile($user);

        /**
         * @var File\Model $file
         */
        $file = File\Model::query()
            ->where('user_owner_id', $user->id)
            ->where('name', self::FILE_NAME)
            ->first();

        $createFileLinkInputDto = new CreateFileLinkInputDTO();
        $createFileLinkInputDto->fileId = $file->id;
        $createFileLinkInputDto->userOwnerId = $user->id;
        $createFileLinkInputDto->typeId = TypesEnum::PERMANENT;

        $createFileLinkUseCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::CREATE_FILE_LINK);
        $createFileLinkUseCase->setInputDTO($createFileLinkInputDto);
        $createFileLinkUseCase->execute();

        $this->assertNotNull(
            Model::query()
                ->where('file_id', $createFileLinkInputDto->fileId)
                ->where('type_id', $createFileLinkInputDto->typeId)
                ->whereNull('expired_at')
                ->whereNotNull('code')
                ->where('is_enabled', true)
                ->where('opens_count', 0)
                ->first()
        );

        $this->removeTempFile($file->path);
    }

    /**
     * Test case, when user tries to create permanent link, when permanent already exists
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCreationOfPermanentLinkWhenPermanentLinkAlreadyExists(): void
    {
        /**
         * @var User\Model $user
         */
        $user = User\Model::query()->create([
            'email' => 'user1@email.com',
            'password' => 'password',
            'name' => 'User 1'
        ]);

        $this->createFile($user);

        /**
         * @var File\Model $file
         */
        $file = File\Model::query()
            ->where('user_owner_id', $user->id)
            ->where('name', self::FILE_NAME)
            ->first();

        $createFileLinkInputDto = new CreateFileLinkInputDTO();
        $createFileLinkInputDto->fileId = $file->id;
        $createFileLinkInputDto->userOwnerId = $user->id;
        $createFileLinkInputDto->typeId = TypesEnum::PERMANENT;

        $createFileLinkUseCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::CREATE_FILE_LINK);
        $createFileLinkUseCase->setInputDTO($createFileLinkInputDto);
        $createFileLinkUseCase->execute();

        $this->expectException(PermanentLinkAlreadyExistsException::class);

        $createFileLinkUseCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::CREATE_FILE_LINK);
        $createFileLinkUseCase->setInputDTO($createFileLinkInputDto);
        $createFileLinkUseCase->execute();
    }

    /**
     * Test case, when user tries to create link for other user's file
     *
     * @test
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testCaseWhenUserTriesToCreateLinkForOtherUsersFile(): void
    {
        /**
         * @var User\Model $user1
         */
        $user1 = User\Model::query()->create([
            'email' => 'user1@email.com',
            'password' => 'password',
            'name' => 'User 1'
        ]);

        $this->createFile($user1);

        /**
         * @var File\Model $file
         */
        $file = File\Model::query()
            ->where('user_owner_id', $user1->id)
            ->where('name', self::FILE_NAME)
            ->first();

        /**
         * @var User\Model $user2
         */
        $user2 = User\Model::query()->create([
            'email' => 'user2@email.com',
            'password' => 'password',
            'name' => 'User 2'
        ]);

        $createFileLinkInputDto = new CreateFileLinkInputDTO();
        $createFileLinkInputDto->fileId = $file->id;
        $createFileLinkInputDto->userOwnerId = $user2->id;
        $createFileLinkInputDto->typeId = TypesEnum::TEMPORARY;
        $createFileLinkInputDto->expiredAt = date('Y-m-d H:i:s', time() + 3600);

        $this->expectException(FileForbiddenException::class);

        $createFileLinkUseCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::CREATE_FILE_LINK);
        $createFileLinkUseCase->setInputDTO($createFileLinkInputDto);
        $createFileLinkUseCase->execute();

        $this->removeTempFile($file->path);
    }

    /**
     * Create file for specific user
     *
     * @param User\Model $user
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    private function createFile(User\Model $user): void
    {
        $createUserFileInputDto = new CreateUserFileInputDTO();
        $createUserFileInputDto->user = $user;
        $createUserFileInputDto->file = new FileDTO();
        $createUserFileInputDto->file->name = self::FILE_NAME;
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
