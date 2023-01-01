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

    /**
     * Get invitation invitation
     *
     * @param string $code
     * @return InvitationDTO
     */
    public function getInvitation(string $code): InvitationDTO;

    /**
     * Set invitation status to "Accepted"
     *
     * @param InvitationDTO $dto
     * @return void
     */
    public function setAccepted(InvitationDTO $dto): void;
}
