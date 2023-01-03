<?php

namespace Tests\UseCases\File;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\User;
use App\Models\File;
use App\UseCases\Common\DTO\FileDTO;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\File\InputDTO\CreateUserFileInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCases\BaseUseCaseTest;

/**
 * Class CreateUserFileUseCaseTest
 * @package Tests\UseCases\File
 */
final class CreateUserFileUseCaseTest extends BaseUseCaseTest
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

        $inputDto = new CreateUserFileInputDTO();
        $inputDto->user = $user;
        $inputDto->description = 'Test description';
        $inputDto->file = new FileDTO();
        $inputDto->file->name = '001.png';
        $inputDto->file->mime = 'image/png';
        $inputDto->file->content = base64_encode(
            file_get_contents(
                base_path('tests/resources/files/001.png')
            )
        );

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_USER_FILE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $file = File\Model::query()
            ->where('user_owner_id', $user->id)
            ->where('name', $inputDto->file->name)
            ->where('mime', $inputDto->file->mime)
            ->whereNotNull('path')
            ->where('sha1', sha1_file(base_path('tests/resources/files/001.png')))
            ->where('description', $inputDto->description)
            ->first();

        $this->assertNotNull($file);

        $this->removeTempFile($file->path);
    }

    /**
     * Test case, when we try to create file, but file already exists
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenWeTryToCreateFileButFileAlreadyExists(): void
    {
        /**
         * @var User\Model $user
         */
        $user = User\Model::query()->create([
            'email' => 'user1@email.com',
            'password' => 'password',
            'name' => 'User 1'
        ]);

        $inputDto = new CreateUserFileInputDTO();
        $inputDto->user = $user;
        $inputDto->description = 'Test description';
        $inputDto->file = new FileDTO();
        $inputDto->file->name = '001.png';
        $inputDto->file->mime = 'image/png';
        $inputDto->file->content = base64_encode(
            file_get_contents(
                base_path('tests/resources/files/001.png')
            )
        );

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_USER_FILE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->expectException(File\Exceptions\FileAlreadyExistsException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_USER_FILE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertEquals(
            1,
            File\Model::query()
                ->where('user_owner_id', $user->id)
                ->count()
        );

        $file = File\Model::query()
            ->where('user_owner_id', $user->id)
            ->first();

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
