<?php

namespace App\Models\Role\Composers;

use App\Models\Common\Composers\BaseDTOComposer;
use App\Models\Role\DTO\RoleDTO;

/**
 * Class RoleDTOComposer
 * @package App\Models\Role\Composers
 */
final class RoleDTOComposer extends BaseDTOComposer
{
    /**
     * Get DTO class name
     *
     * @return string
     */
    function getDTOClass(): string
    {
        return RoleDTO::class;
    }
}
