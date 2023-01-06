<?php

namespace Tests\UseCases\File;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\File;
use App\Models\User;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\File\GetUserFilesUseCase;
use App\UseCases\File\InputDTO\GetUserFilesInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCases\BaseUseCaseTest;

/**
 * Class GetUserFilesUseCaseTest
 * @package Tests\UseCases\File
 */
final class GetUserFilesUseCaseTest extends BaseUseCaseTest
{
    /**
     * Files data list
     * @var array
     */
    private array $filesData = [
        [
            'name' => '001.png',
            'mime' => 'image/png',
            'size' => 100,
            'path' => '001.png',
            'sha1' => 'hash',
            'description' => 'Description one'
        ],
        [
            'name' => 'abc.jpg',
            'mime' => 'image/jpg',
            'size' => 200,
            'path' => 'abc.jpg',
            'sha1' => 'hash',
        ],
    ];

    /**
     * Test case without limit, offset and sorting
     *
     * @test
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testCaseWithoutLimitOffsetAndSorting(): void
    {
        /**
         * @var User\Model $user
         */
        $user = User\Model::query()->create([
            'email' => 'user1@email.com',
            'password' => 'password',
            'name' => 'User 1'
        ]);
        $this->createFilesForUser($user);

        $inputDto = new GetUserFilesInputDTO();
        $inputDto->user = $user;

        /**
         * @var GetUserFilesUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_USER_FILES);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertEquals(
            2,
            $useCase->getList()->count
        );
        $this->assertEquals(
            $this->filesData[0]['name'],
            $useCase->getList()->items[0]->name
        );
        $this->assertEquals(
            $this->filesData[1]['name'],
            $useCase->getList()->items[1]->name
        );
        $this->assertCount(
            2,
            $useCase->getList()->items
        );
    }

    /**
     * Test case when we use limit and offset parameters
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWithLimitOffset(): void
    {
        /**
         * @var User\Model $user
         */
        $user = User\Model::query()->create([
            'email' => 'user1@email.com',
            'password' => 'password',
            'name' => 'User 1'
        ]);
        $this->createFilesForUser($user);

        $inputDto = new GetUserFilesInputDTO();
        $inputDto->user = $user;
        $inputDto->limit = 10;
        $inputDto->offset = 1;

        /**
         * @var GetUserFilesUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_USER_FILES);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertEquals(
            2,
            $useCase->getList()->count
        );
        $this->assertEquals(
            $this->filesData[1]['name'],
            $useCase->getList()->items[0]->name
        );
        $this->assertCount(
            1,
            $useCase->getList()->items
        );
    }

    /**
     * Test case when we use limit, offset and sorting parameters
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWithLimitOffsetAndSorting(): void
    {
        /**
         * @var User\Model $user
         */
        $user = User\Model::query()->create([
            'email' => 'user1@email.com',
            'password' => 'password',
            'name' => 'User 1'
        ]);
        $this->createFilesForUser($user);

        $inputDto = new GetUserFilesInputDTO();
        $inputDto->user = $user;
        $inputDto->limit = 10;
        $inputDto->offset = 0;
        $inputDto->sortBy = 'size';
        $inputDto->sortDirection = 'desc';

        /**
         * @var GetUserFilesUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_USER_FILES);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertEquals(
            2,
            $useCase->getList()->count
        );
        $this->assertEquals(
            $this->filesData[1]['name'],
            $useCase->getList()->items[0]->name
        );
        $this->assertEquals(
            $this->filesData[0]['name'],
            $useCase->getList()->items[1]->name
        );
        $this->assertCount(
            2,
            $useCase->getList()->items
        );
    }

    /**
     * Test case when user doesn't have files
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenUserDoesntHaveFiles(): void
    {
        /**
         * @var User\Model $user1
         */
        $user1 = User\Model::query()->create([
            'email' => 'user1@email.com',
            'password' => 'password',
            'name' => 'User 1'
        ]);
        /**
         * @var User\Model $user2
         */
        $user2 = User\Model::query()->create([
            'email' => 'user2@email.com',
            'password' => 'password',
            'name' => 'User 2'
        ]);
        $this->createFilesForUser($user1);

        $inputDto = new GetUserFilesInputDTO();
        $inputDto->user = $user2;

        /**
         * @var GetUserFilesUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_USER_FILES);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertEquals(
            0,
            $useCase->getList()->count
        );
        $this->assertCount(
            0,
            $useCase->getList()->items
        );
    }

    /**
     * Create files for specific user
     *
     * @param User\Model $user
     * @return void
     */
    private function createFilesForUser(User\Model $user): void
    {
        foreach ($this->filesData as $fileData) {
            File\Model::query()->create(
                array_merge(
                    [
                        'user_owner_id' => $user->id,
                    ],
                    $fileData
                )
            );
        }
    }
}
