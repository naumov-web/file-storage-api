<?php

namespace App\Models\Role\DTO;

use App\Models\Common\DTO\ModelDTO;

/**
 * Class RoleDTO
 * @package App\Models\Role\InputDTO
 */
final class RoleDTO extends ModelDTO
{
    /**
     * Role id value
     * @var int
     */
    public int $id;

    /**
     * Role name value
     * @var string
     */
    public string $name;

    /**
     * Role system name value
     * @var string|null
     */
    public string|null $systemName = null;
}
