<?php

namespace App\Models\File\Repositories;

use App\Models\Common\DTO\ListDTO;
use App\Models\File\Contracts\IFileCacheRepository;
use App\Models\File\Contracts\IFileDatabaseRepository;
use App\Models\File\DTO\FileDTO;
use App\Models\File\DTO\GetUserFilesDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheRepository
 * @package App\Models\File\Repositories
 */
final class CacheRepository implements IFileCacheRepository
{
    /**
     * CacheRepository constructor
     * @param IFileDatabaseRepository $databaseRepository
     */
    public function __construct(private IFileDatabaseRepository $databaseRepository) {}

    /**
     * @inheritDoc
     */
    public function getVersionNumber(): string
    {
        return '1';
    }

    /**
     * @inheritDoc
     */
    public function getDirectoryKey(): string
    {
        return 'user-files/v' . $this->getVersionNumber();
    }

    /**
     * @inheritDoc
     */
    public function resetCacheForUser(int $userOwnerId): void
    {
        $tag = $this->getUserTag($userOwnerId);
        Cache::tags([$tag])->flush();
    }

    /**
     * @inheritDoc
     */
    public function resetCacheForFiles(array $fileIds): void
    {
        foreach ($fileIds as $fileId) {
            $tag = $this->getFileTag($fileId);

            Cache::tags([$tag])->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function getUserFiles(int $userOwnerId): Collection
    {
        $keyName = $this->getUserFilesKey($userOwnerId);
        $items = Cache::get($keyName);

        if ($items) {
            return $items;
        } else {
            $items = $this->databaseRepository->getUserFiles($userOwnerId);
            Cache::tags(
                array_merge(
                    [
                        $this->getUserTag($userOwnerId)
                    ],
                    $this->getFileTags($items)
                )
            )->put($keyName, $items);

            return $items;
        }
    }

    /**
     * @inheritDoc
     */
    public function getFileForOwner(int $id, int $userOwnerId): ?FileDTO
    {
        $files = $this->getUserFiles($userOwnerId);

        foreach ($files as $file) {
            /**
             * @var FileDTO $file
             */
            if ($file->id === $id) {
                return $file;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getFile(int $fileId): ?FileDTO
    {
        $keyName = $this->getDirectoryKey() . '/files/' . $fileId;
        $file = Cache::get($keyName);

        if ($file) {
            return $file;
        } else {
            $file = $this->databaseRepository->getFile($fileId);

            if (!$file) {
                return null;
            }

            Cache::put($keyName, $file);

            return $file;
        }
    }

    /**
     * @inheritDoc
     */
    public function getUserFilesList(GetUserFilesDTO $dto): ListDTO
    {
        $keyName = $this->getUserFilesListKey($dto);
        $listDto = Cache::get($keyName);

        if ($listDto) {
            return $listDto;
        } else {
            $listDto = $this->databaseRepository->getUserFilesList($dto);
            Cache::tags([
                $this->getUserFilesKey($dto->userOwnerId)
            ])->put($keyName, $listDto);

            return $listDto;
        }
    }

    /**
     * Get user files key
     *
     * @param int $userOwnerId
     * @return string
     */
    private function getUserFilesKey(int $userOwnerId): string
    {
        return 'users/' . $userOwnerId . '/files';
    }

    /**
     * Get cache key name for user files list
     *
     * @param GetUserFilesDTO $dto
     * @return string
     */
    private function getUserFilesListKey(GetUserFilesDTO $dto): string
    {
        $result = 'users/' . $dto->userOwnerId . '/files';

        if (isset($dto->limit)) {
            $result .= ('/limit/' . $dto->limit);
        }

        if (isset($dto->offset)) {
            $result .= ('/offset/' . $dto->offset);
        }

        if ($dto->sortBy && $dto->sortDirection) {
            $result .= ('/order/' . $dto->sortBy . '/' . $dto->sortDirection);
        }

        return $result;
    }

    /**
     * Get tag for specific user
     *
     * @param int $userOwnerId
     * @return string
     */
    private function getUserTag(int $userOwnerId): string
    {
        return 'users/' . $userOwnerId . '/files';
    }

    /**
     * Get file tags from file collection
     *
     * @param Collection $items
     * @return array
     */
    private function getFileTags(Collection $items): array
    {
        $result = [];

        foreach ($items as $item) {
            /**
             * @var FileDTO $item
             */
            $result[] = $this->getFileTag($item->id);
        }

        return $result;
    }

    /**
     * Get file tag by file id
     *
     * @param int $fileId
     * @return string
     */
    private function getFileTag(int $fileId): string
    {
        return 'tag(files/' . $fileId . ')';
    }
}
