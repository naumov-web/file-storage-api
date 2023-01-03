<?php

namespace App\Models\File\Repositories;

use App\Models\File\Contracts\IFileCacheRepository;
use App\Models\File\Contracts\IFileDatabaseRepository;
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
        $keyName = $this->getDirectoryKey() . '/index';
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
        return 'user/' . $userOwnerId . '/files';
    }

    /**
     * @inheritDoc
     */
    public function resetCacheForUser(int $userOwnerId): void
    {
        $tag = $this->getUserTag($userOwnerId);
        Cache::tags([$tag])->flush();
    }
}
