<?php

namespace App\Models\File\Service;

use App\Gateways\Contracts\IFileGatewayInterface;
use App\Models\Common\DTO\FilePathDTO;
use App\Models\File\Contracts\IFileCacheRepository;
use App\Models\File\Contracts\IFileDatabaseRepository;
use App\Models\File\Contracts\IFileService;
use App\Models\File\DTO\FileDTO;
use App\Models\File\Exceptions\FileAlreadyExistsException;

/**
 * Class Service
 * @package App\Models\File\Service
 */
final class Service implements IFileService
{
    /**
     * Service constructor
     * @param IFileGatewayInterface $fileGateway
     * @param IFileCacheRepository $cacheRepository
     * @param IFileDatabaseRepository $databaseRepository
     */
    public function __construct(
        private IFileGatewayInterface $fileGateway,
        private IFileCacheRepository $cacheRepository,
        private IFileDatabaseRepository $databaseRepository
    ) {}

    /**
     * @inheritDoc
     */
    public function saveContentToFile(string $name, string $content): FilePathDTO
    {
        return $this->fileGateway->saveContent($name, $content);
    }

    /**
     * @inheritDoc
     * @throws FileAlreadyExistsException
     */
    public function create(FileDTO $dto): FileDTO
    {
        $userFiles = $this->cacheRepository->getUserFiles($dto->userOwnerId);

        foreach ($userFiles as $userFile) {
            /**
             * @var FileDTO $userFile
             */
            if ($userFile->sha1 === $dto->sha1) {
                throw new FileAlreadyExistsException();
            }
        }

        $dto = $this->databaseRepository->create($dto);
        $this->cacheRepository->resetCacheForUser($dto->userOwnerId);

        return $dto;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id, int $userOwnerId): void
    {
        $dto = $this->cacheRepository->getFile($id, $userOwnerId);

        if (!$dto) {
            return;
        }

        $this->databaseRepository->delete($dto);
        $this->fileGateway->delete($dto->path);
        $this->cacheRepository->resetCacheForUser($userOwnerId);
    }
}
