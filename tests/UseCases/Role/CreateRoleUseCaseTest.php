<?php

namespace Tests\UseCases\Role;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\Role\Exceptions\RoleWithNameAlreadyExistsException;
use App\Models\Role\Exceptions\RoleWithSystemNameAlreadyExistsException;
use App\Models\Role\Model;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\Role\InputDTO\CreateRoleInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCases\BaseUseCaseTest;

/**
 * Class CreateRoleUseCaseTest
 * @package Tests\UseCase\Role
 */
final class CreateRoleUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test case when role with name and system name doesn't exist
     *
     * @test
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testCaseWhenRoleWithNameAndSystemNameDoesntExist(): void
    {
        $inputDto = new CreateRoleInputDTO();
        $inputDto->name = 'Admin';
        $inputDto->systemName = 'admin';

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_ROLE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertDatabaseHas(
            (new Model())->getTable(),
            [
                'name' => $inputDto->name,
                'system_name' => $inputDto->systemName,
            ]
        );
    }

    /**
     * Test case when we create role only with name
     *
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenWeCreateRoleOnlyWithName(): void
    {
        $inputDto = new CreateRoleInputDTO();
        $inputDto->name = 'Admin';

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_ROLE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertDatabaseHas(
            (new Model())->getTable(),
            [
                'name' => $inputDto->name,
            ]
        );
    }

    /**
     * Test case, when we try to create role, but role with this name already exists
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenWeTryToCreateRoleButRoleWithThisNameAlreadyExists(): void
    {
        $inputDto = new CreateRoleInputDTO();
        $inputDto->name = 'Admin';

        Model::query()->create([
            'name' => $inputDto->name
        ]);

        $this->expectException(RoleWithNameAlreadyExistsException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_ROLE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();
    }

    /**
     * Test case when we try to create role, but role with this system name already exists
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenWeTryToCreateRoleButRoleWithThisSystemNameAlreadyExists(): void
    {
        $inputDto = new CreateRoleInputDTO();
        $inputDto->name = 'Admin';
        $inputDto->systemName = 'administrator';

        Model::query()->create([
            'name' => $inputDto->name,
            'system_name' => $inputDto->systemName,
        ]);

        $inputDto->name = 'Administrator';

        $this->expectException(RoleWithSystemNameAlreadyExistsException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_ROLE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();
    }
}
