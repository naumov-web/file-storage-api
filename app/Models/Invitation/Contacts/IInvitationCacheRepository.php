<?php

namespace App\Models\Invitation\Contacts;

use App\Models\Common\Contacts\ICacheRepository;
use App\Models\Invitation\DTO\InvitationDTO;

/**
 * Interface IInvitationCacheRepository
 * @package App\Models\Invitation\Contacts
 */
interface IInvitationCacheRepository extends IInvitationRepository, ICacheRepository
{
    /**
     * Reset cache for getting of all invitations
     *
     * @return void
     */
    public function resetAllInvitationsCache(): void;

    /**
     * Get invitation by email value
     *
     * @param string $email
     * @return InvitationDTO|null
     */
    public function getInvitationByEmail(string $email): InvitationDTO|null;
}
