<?php

namespace App\Models\File\Repositories;

use App\Models\File\Contracts\IFileCacheRepository;
use App\Models\File\Contracts\IFileDatabaseRepository;
use App\Models\File\DTO\FileDTO;
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
    public function getUserFiles(int $userOwnerId): Collection
    {
        $keyName = $this->getUserFilesKey($userOwnerId);
        $items = Cache::get($keyName);

        if ($items) {
            return $items;
        } else {
            $items = $this->databaseRepository->getUserFiles($userOwnerId);
            Cache::tags([$this->getUserTag($userOwnerId)])
                ->put($keyName, $items);

            return $items;
        }
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
    public function getFile(int $id, int $userOwnerId): ?FileDTO
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
}
