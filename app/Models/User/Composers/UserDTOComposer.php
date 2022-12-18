<?php

namespace App\Models\User\Composers;

use App\Models\Common\Composers\BaseDTOComposer;
use App\Models\User\DTO\UserDTO;

/**
 * Class UserDTOComposer
 * @package App\Models\User\Composers
 */
final class UserDTOComposer extends BaseDTOComposer
{

    /**
     * @inheritDoc
     */
    function getDTOClass(): string
    {
        return UserDTO::class;
    }
}
