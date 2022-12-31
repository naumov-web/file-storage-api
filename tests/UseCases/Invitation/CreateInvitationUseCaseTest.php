<?php

namespace Tests\UseCases\Invitation;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\Invitation\Enums\StatusesEnum;
use App\Models\Invitation\Exceptions\InvitationForEmailAlreadyExistsException;
use App\Models\Invitation\Model;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\Invitation\InputDTO\CreateInvitationInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCases\BaseUseCaseTest;

/**
 * Class CreateInvitationUseCaseTest
 * @package Tests\UseCases\Invitation
 */
final class CreateInvitationUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test case, when we try to create invitation, but invitation with the email already exists with status "Wait"
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenWeTryToCreateInvitationButInvitationExistsForEmailInWaitStatus(): void
    {
        $inputDto = new CreateInvitationInputDTO();
        $inputDto->email = 'user1@email.com';
        $inputDto->password = 'password';
        $inputDto->name = 'Name 1';
        $inputDto->expiredAt = date('Y-m-d H:i:s', time() + 3600 * 24);

        Model::query()->create([
            'email' => $inputDto->email,
            'password' => 'password',
            'name' => $inputDto->name,
            'expired_at' => $inputDto->expiredAt,
            'invitation_code' => 'code',
            'status_id' => StatusesEnum::WAIT
        ]);

        $this->expectException(InvitationForEmailAlreadyExistsException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_INVITATION);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();
    }

    /**
     * Test case, when we try to create invitation and invitation with the email already exists with status "Expired"
     *
     * @test
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenWeTryToCreateInvitationAndInvitationExistsForEmailInExpiredStatus(): void
    {
        $inputDto = new CreateInvitationInputDTO();
        $inputDto->email = 'user1@email.com';
        $inputDto->password = 'password';
        $inputDto->name = 'Name 1';
        $inputDto->expiredAt = date('Y-m-d H:i:s', time() + 3600 * 24);

        /**
         * @var Model $oldInvitation
         */
        $oldInvitation = Model::query()->create([
            'email' => $inputDto->email,
            'password' => 'password',
            'name' => $inputDto->name,
            'expired_at' => $inputDto->expiredAt,
            'invitation_code' => 'code',
            'status_id' => StatusesEnum::EXPIRED
        ]);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_INVITATION);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertNotNull(
            Model::query()
                ->where('id', '<>', $oldInvitation->id)
                ->where('email', $inputDto->email)
                ->whereNotNull('password')
                ->where('name', $inputDto->name)
                ->where('expired_at', $inputDto->expiredAt)
                ->whereNotNull('invitation_code')
                ->where('status_id', StatusesEnum::WAIT)
                ->first()
        );
    }

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
        $inputDto = new CreateInvitationInputDTO();
        $inputDto->email = 'user1@email.com';
        $inputDto->password = 'password';
        $inputDto->name = 'Name 1';
        $inputDto->expiredAt = date('Y-m-d H:i:s', time() + 3600 * 24);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_INVITATION);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $this->assertNotNull(
            Model::query()
                ->where('email', $inputDto->email)
                ->whereNotNull('password')
                ->where('name', $inputDto->name)
                ->where('expired_at', $inputDto->expiredAt)
                ->whereNotNull('invitation_code')
                ->where('status_id', StatusesEnum::WAIT)
                ->first()
        );
    }
}
