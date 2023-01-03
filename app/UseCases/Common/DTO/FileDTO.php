<?php

namespace App\UseCases\Common\DTO;

/**
 * Class FileDTO
 * @package App\UseCases\Common\DTO
 */
final class FileDTO
{
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
     * File content value
     * @var string
     */
    public string $content;
}
