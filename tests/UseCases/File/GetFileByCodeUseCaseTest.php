<?php

namespace Tests\UseCases\File;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\File;
use App\Models\Link;
use App\Models\User;
use App\UseCases\Common\DTO\FileDTO;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\File\GetFileByCodeUseCase;
use App\UseCases\File\InputDTO\CreateUserFileInputDTO;
use App\UseCases\File\InputDTO\GetFileByCodeInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCases\BaseUseCaseTest;

/**
 * Class GetFileByCodeUseCaseTest
 * @package Tests\UseCases\File
 */
final class GetFileByCodeUseCaseTest extends BaseUseCaseTest
{
    /**
     * File name value
     * @var string
     */
    const FILE_NAME = '0001.png';

    /**
     * Test case, when we try to get file but link doesn't exist
     *
     * @test
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testCaseWhenWeTryToGetFileButLinkDoesntExist(): void
    {
        $this->expectException(Link\Exceptions\LinkDoesntExistException::class);

        $inputDto = new GetFileByCodeInputDTO();
        $inputDto->linkCode = 'code';

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_FILE_BY_CODE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();
    }

    /**
     * Test case, when we try to get file but link expired
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenWeTryToGetFileButLinkExpired(): void
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

        $link1 = Link\Model::query()->create([
            'file_id' => $file->id,
            'type_id' => Link\Enums\TypesEnum::TEMPORARY,
            'code' => 'code1',
            'expired_at' => date('Y-m-d H:i:s', time() - 3600)
        ]);

        $this->expectException(Link\Exceptions\LinkExpiredException::class);

        $inputDto = new GetFileByCodeInputDTO();
        $inputDto->linkCode = $link1->code;

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_FILE_BY_CODE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->removeTempFile($file->path);
    }

    /**
     * Test success case
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
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

        $this->createFile($user);

        /**
         * @var File\Model $file
         */
        $file = File\Model::query()
            ->where('user_owner_id', $user->id)
            ->where('name', self::FILE_NAME)
            ->first();

        $link1 = Link\Model::query()->create([
            'file_id' => $file->id,
            'type_id' => Link\Enums\TypesEnum::TEMPORARY,
            'code' => 'code1',
            'expired_at' => date('Y-m-d H:i:s', time() + 3600)
        ]);

        $inputDto = new GetFileByCodeInputDTO();
        $inputDto->linkCode = $link1->code;

        /**
         * @var GetFileByCodeUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_FILE_BY_CODE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertNotNull(
            $useCase->getFullFilePath()
        );

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
