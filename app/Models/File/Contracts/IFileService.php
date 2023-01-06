<?php

namespace App\Models\File\Contracts;

use App\Models\Common\DTO\FileSavingResultDTO;
use App\Models\Common\DTO\ListDTO;
use App\Models\File\DTO\FileDTO;
use App\Models\File\DTO\GetUserFilesDTO;

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
     * @return FileSavingResultDTO
     */
    public function saveContentToFile(string $name, string $content): FileSavingResultDTO;

    /**
     * Delete file by path
     *
     * @param string $path
     * @return void
     */
    public function deleteFileByPath(string $path): void;

    /**
     * Create file instance
     *
     * @param FileDTO $dto
     * @return FileDTO
     */
    public function create(FileDTO $dto): FileDTO;

    /**
     * Delete file instance by id
     *
     * @param int $id
     * @param int $userOwnerId
     * @return void
     */
    public function delete(int $id, int $userOwnerId): void;

    /**
     * Get file full path by id
     *
     * @param int $fileId
     * @return string
     */
    public function getFileFullPath(int $fileId): string;

    /**
     * Get user files list
     *
     * @param GetUserFilesDTO $dto
     * @return ListDTO
     */
    public function getUserFileList(GetUserFilesDTO $dto): ListDTO;
}
