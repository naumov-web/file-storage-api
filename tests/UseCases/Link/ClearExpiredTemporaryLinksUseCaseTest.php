<?php

namespace Tests\UseCases\Link;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\File;
use App\Models\Link;
use App\Models\User;
use App\UseCases\Common\DTO\FileDTO;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\File\InputDTO\CreateUserFileInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCases\BaseUseCaseTest;

/**
 * Class ClearExpiredTemporaryLinksUseCaseTest
 * @package Tests\UseCases\Link
 */
final class ClearExpiredTemporaryLinksUseCaseTest extends BaseUseCaseTest
{
    /**
     * File name value
     * @var string
     */
    const FILE_NAME = '0001.png';

    /**
     * Test case when file has expired temporary link
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenFileHasExpiredTemporaryLink(): void
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
        $link2 = Link\Model::query()->create([
            'file_id' => $file->id,
            'type_id' => Link\Enums\TypesEnum::TEMPORARY,
            'code' => 'code1',
            'expired_at' => date('Y-m-d H:i:s', time() + 3600)
        ]);

        $useCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::CLEAR_EXPIRED_TEMPORARY_LINKS);
        $useCase->execute();

        $this->assertNull(
            Link\Model::query()->where('id', $link1->id)->first()
        );
        $this->assertNotNull(
            Link\Model::query()->where('id', $link2->id)->first()
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
