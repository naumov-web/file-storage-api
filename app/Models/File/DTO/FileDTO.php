<?php

namespace App\Models\File\DTO;

use App\Models\Common\DTO\ModelDTO;

/**
 * Class FileDTO
 * @package App\Models\File\DTO
 */
final class FileDTO extends ModelDTO
{
    /**
     * File id value
     * @var int
     */
    public int $id;

    /**
     * File user owner id value
     * @var int
     */
    public int $userOwnerId;

    /**
     * File name value
     * @var string
     */
    public string $name;

    /**
     * File mime value
     * @var string
     */
    public string $mime;

    /**
     * File size value
     * @var int
     */
    public int $size;

    /**
     * File path value
     * @var string
     */
    public string $path;

    /**
     * File sha1 hash value
     * @var string|null
     */
    public string|null $sha1;

    /**
     * File description value
     * @var string|null
     */
    public string|null $description;
}
