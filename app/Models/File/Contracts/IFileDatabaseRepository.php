<?php

namespace App\Models\File\Contracts;

use App\Models\File\DTO\FileDTO;

/**
 * Interface IFileDatabaseRepository
 * @package App\Models\File\Contracts
 */
interface IFileDatabaseRepository extends IFileRepository
{
    /**
     * Create file instance in database
     *
     * @param FileDTO $dto
     * @return FileDTO
     */
    public function create(FileDTO $dto): FileDTO;
}
