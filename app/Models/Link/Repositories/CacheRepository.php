<?php

namespace App\Models\Link\Repositories;

use App\Models\Link\Contracts\ILinkCacheRepository;
use App\Models\Link\Contracts\ILinkDatabaseRepository;
use App\Models\Link\DTO\LinkDTO;
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
    public function resetCacheForFiles(array $fileIds): void
    {
        foreach ($fileIds as $fileId) {
            Cache::tags([$this->getFileLinksTag($fileId)])->flush();
        }
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
            Cache::tags([$this->getFileLinksTag($fileId)])
                ->put($keyName, $items);

            return $items;
        }
    }

    /**
     * @inheritDoc
     */
    public function getLinkByCode(string $code): LinkDTO|null
    {
        $keyName = $this->getLinkKey($code);
        $dto = Cache::get($keyName);

        if ($dto) {
            return $dto;
        } else {
            $dto = $this->databaseRepository->getLinkByCode($code);

            if (!$dto) {
                return null;
            }

            Cache::tags([$this->getFileLinksTag($dto->fileId)])
                ->put($keyName, $dto);

            return $dto;
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

    /**
     * Get link key
     *
     * @param string $code
     * @return string
     */
    private function getLinkKey(string $code): string
    {
        return 'links/' . $code;
    }

    /**
     * Get file links key
     *
     * @param int $fileId
     * @return string
     */
    private function getFileLinksTag(int $fileId): string
    {
        return 'tag(files/' . $fileId . '/links)';
    }
}
