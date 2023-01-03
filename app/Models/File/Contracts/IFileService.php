<?php

namespace App\Models\File\Contracts;

use App\Models\Common\DTO\FilePathDTO;
use App\Models\File\DTO\FileDTO;

/**
 * Interface IFileService
 * @package App\Models\File\Contracts
 */
interface IFileService
{
    /**
     * Save content to file
     *
     * @param string $name
     * @param string $content
     * @return FilePathDTO
     */
    public function saveContentToFile(string $name, string $content): FilePathDTO;

    /**
     * Create file instance
     *
     * @param FileDTO $dto
     * @return FileDTO
     */
    public function create(FileDTO $dto): FileDTO;
}
