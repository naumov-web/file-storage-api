<?php

namespace App\Models\Invitation\Composers;

use App\Models\Common\Composers\BaseDTOComposer;
use App\Models\Invitation\DTO\InvitationDTO;

/**
 * Class InvitationDTOComposer
 * @package App\Models\Invitation\Composers
 */
final class InvitationDTOComposer extends BaseDTOComposer
{

    /**
     * @inheritDoc
     */
    function getDTOClass(): string
    {
        return InvitationDTO::class;
    }
}
