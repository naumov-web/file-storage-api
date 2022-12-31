<?php

namespace App\Models\Invitation\Contacts;

use App\Models\Invitation\DTO\InvitationDTO;

/**
 * Interface IInvitationService
 * @package App\Models\Invitation\Contacts
 */
interface IInvitationService
{
    /**
     * Create invitation
     *
     * @param InvitationDTO $dto
     * @return InvitationDTO
     */
    public function create(InvitationDTO $dto): InvitationDTO;
}
