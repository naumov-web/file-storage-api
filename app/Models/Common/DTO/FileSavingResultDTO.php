<?php

namespace App\Models\Common\DTO;

/**
 * Class FileSavingResultDTO
 * @package App\Models\Common\DTO
 */
final class FileSavingResultDTO
{
    /**
     * File path value
     * @var string
     */
    public string $path;

    /**
     * Full file path value
     * @var string
     */
    public string $fullPath;

    /**
     * File sha1 hash value
     * @var string
     */
    public string $sha1;

    /**
     * File size value
     * @var int
     */
    public int $size;
}
