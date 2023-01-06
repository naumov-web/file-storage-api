<?php

namespace App\Models\File\DTO;

use App\Models\Common\DTO\ListQueryDTO;

/**
 * Class GetUserFilesDTO
 * @package App\Models\File\DTO
 */
final class GetUserFilesDTO extends ListQueryDTO
{
    /**
     * User owner id value
     * @var int
     */
    public int $userOwnerId;
}
