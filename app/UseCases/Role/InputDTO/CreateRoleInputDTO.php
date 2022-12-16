<?php

namespace App\UseCases\Role\InputDTO;

use App\UseCases\Common\DTO\BaseUseCaseDTO;

/**
 * Class CreateRoleInputDTO
 * @package App\UseCases\Role\InputDTO
 */
final class CreateRoleInputDTO extends BaseUseCaseDTO
{
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
