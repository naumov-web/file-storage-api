<?php

namespace App\Models\Invitation\Contacts;

use App\Models\Invitation\DTO\InvitationDTO;
use Illuminate\Support\Collection;

/**
 * Interface IInvitationRepository
 * @package App\Models\Invitation\Contacts
 */
interface IInvitationRepository
{
    /**
     * Get invitations collection
     *
     * @return Collection
     */
    public function getInvitations(): Collection;
}
