<?php

namespace App\UseCases\Invitation;

use App\Models\Invitation\Contacts\IInvitationService;
use App\Models\Invitation\DTO\InvitationDTO;
use App\Models\Invitation\Emails\InvitationCreated;
use App\UseCases\BaseUseCase;
use App\UseCases\Invitation\InputDTO\CreateInvitationInputDTO;
use Illuminate\Support\Facades\Mail;

/**
 * Class CreateInvitationUseCase
 * @package App\UseCases\Invitation
 */
final class CreateInvitationUseCase extends BaseUseCase
{
    /**
     * CreateInvitationUseCase constructor
     * @param IInvitationService $service
     */
    public function __construct(private IInvitationService $service) {}

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return CreateInvitationInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $dto = new InvitationDTO();
        $dto->email = $this->inputDto->email;
        $dto->name = $this->inputDto->name;
        $dto->password = $this->inputDto->password;
        $dto->expiredAt = $this->inputDto->expiredAt;

        $dto = $this->service->create($dto);

        $this->sendInvitationEmail($dto);
    }

    /**
     * Send invitation email
     *
     * @param InvitationDTO $dto
     * @return void
     */
    private function sendInvitationEmail(InvitationDTO $dto): void
    {
        Mail::to([$dto->email])
            ->queue(
                new InvitationCreated(
                    $dto
                )
            );
    }
}
