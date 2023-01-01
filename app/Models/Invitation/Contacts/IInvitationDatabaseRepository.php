<?php

namespace App\Models\Invitation\Contacts;

use App\Models\Invitation\DTO\InvitationDTO;

/**
 * Interface IInvitationDatabaseRepository
 * @package App\Models\Invitation\Contacts
 */
interface IInvitationDatabaseRepository extends IInvitationRepository
{
    /**
     * Create invitation instance
     *
     * @param InvitationDTO $dto
     * @return InvitationDTO
     */
    public function create(InvitationDTO $dto): InvitationDTO;

    /**
     * Update status for invitation instance
     *
     * @param InvitationDTO $dto
     * @return void
     */
    public function updateStatus(InvitationDTO $dto): void;
}
