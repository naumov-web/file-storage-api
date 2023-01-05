<?php

namespace App\Models\Link\Repositories;

use App\Models\Link\Contracts\ILinkCacheRepository;
use App\Models\Link\Contracts\ILinkDatabaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheRepository
 * @package App\Models\Link\Repositories
 */
final class CacheRepository implements ILinkCacheRepository
{
    /**
     * CacheRepository constructor
     * @param ILinkDatabaseRepository $databaseRepository
     */
    public function __construct(private ILinkDatabaseRepository $databaseRepository) {}

    /**
     * @inheritDoc
     */
    public function resetCacheForFile(int $fileId): void
    {
        Cache::forget($this->getFileLinksKey($fileId));
    }

    /**
     * @inheritDoc
     */
    public function getLinks(int $fileId): Collection
    {
        $keyName = $this->getFileLinksKey($fileId);
        $items = Cache::get($keyName);

        if ($items) {
            return $items;
        } else {
            $items = $this->databaseRepository->getLinks($fileId);
            Cache::put($keyName, $items);

            return $items;
        }
    }

    /**
     * Get file links key
     *
     * @param int $fileId
     * @return string
     */
    private function getFileLinksKey(int $fileId): string
    {
        return 'files/' . $fileId . '/links';
    }
}
