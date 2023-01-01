<?php

namespace Tests\UseCases\Invitation;

use App\Enums\UseCaseSystemNamesEnum;
use App\Models\Invitation\Enums\StatusesEnum;
use App\Models\Invitation\Exceptions\InvitationDoesntExistException;
use App\Models\Invitation\Exceptions\InvitationExpiredException;
use App\Models\Invitation\Model;
use App\Models\User;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\Invitation\InputDTO\ConfirmInvitationInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\UseCases\BaseUseCaseTest;

/**
 * Class ConfirmInvitationUseCaseTest
 * @package Tests\UseCases\Invitation
 */
final class ConfirmInvitationUseCaseTest extends BaseUseCaseTest
{
    /**
     * Test success case, when invitation in status "Wait" exists
     *
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testSuccessWhenInvitationExists(): void
    {
        $this->createRoles();

        $invitationData = [
            'email' => 'email1@email.com',
            'password' => 'password',
            'name' => 'User name 1',
            'invitation_code' => 'code-123',
            'status_id' => StatusesEnum::WAIT,
            'expired_at' => date('Y-m-d H:i:s', time() + 3600)
        ];
        /**
         * @var Model $invitation
         */
        $invitation = Model::query()->create($invitationData);

        $inputDto = new ConfirmInvitationInputDTO();
        $inputDto->code = $invitation->invitation_code;

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CONFIRM_INVITATION);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $invitation->refresh();

        $this->assertEquals(
            StatusesEnum::ACCEPTED,
            $invitation->status_id
        );

        /**
         * @var User\Model $user
         */
        $user = User\Model::query()
            ->where('email', $invitation->email)
            ->where('password', $invitation->password)
            ->where('name', $invitation->name)
            ->whereNull('confirmation_code')
            ->first();

        $this->assertNotNull($user);

        $this->assertEquals(
            1,
            $user->roles()->count()
        );
        $this->assertEquals(
            'user',
            $user->roles->first()->system_name
        );
    }

    /**
     * Test case, when invitation doesn't exist
     *
     * @return void
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function testCaseWhenInvitationDoesntExist(): void
    {
        $inputDto = new ConfirmInvitationInputDTO();
        $inputDto->code = 'code-123';

        $this->expectException(InvitationDoesntExistException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CONFIRM_INVITATION);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();
    }

    /**
     * Test success case, when invitation in status "Wait" exists, but it's expired
     *
     * @return void
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function testSuccessWhenInvitationExpired(): void
    {
        $this->createRoles();

        $invitationData = [
            'email' => 'email1@email.com',
            'password' => 'password',
            'name' => 'User name 1',
            'invitation_code' => 'code-123',
            'status_id' => StatusesEnum::WAIT,
            'expired_at' => date('Y-m-d H:i:s', time() - 3600)
        ];
        /**
         * @var Model $invitation
         */
        $invitation = Model::query()->create($invitationData);

        $inputDto = new ConfirmInvitationInputDTO();
        $inputDto->code = $invitation->invitation_code;

        $this->expectException(InvitationExpiredException::class);

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CONFIRM_INVITATION);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $invitation->refresh();

        $this->assertEquals(
            StatusesEnum::EXPIRED,
            $invitation->status_id
        );
    }
}
