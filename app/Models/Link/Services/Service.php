<?php

namespace App\Models\Link\Services;

use App\Models\Link\Contracts\ILinkCacheRepository;
use App\Models\Link\Contracts\ILinkDatabaseRepository;
use App\Models\Link\Contracts\ILinkService;
use App\Models\Link\DTO\LinkDTO;
use Illuminate\Support\Str;

/**
 * Class Service
 * @package App\Models\Link\Services
 */
final class Service implements ILinkService
{
    /**
     * Code length value
     * @var int
     */
    const CODE_LENGTH = 20;

    /**
     * Service constructor
     * @param ILinkCacheRepository $cacheRepository
     * @param ILinkDatabaseRepository $databaseRepository
     */
    public function __construct(
        private ILinkCacheRepository $cacheRepository,
        private ILinkDatabaseRepository $databaseRepository
    ) {}

    /**
     * @inheritDoc
     */
    public function create(LinkDTO $dto): LinkDTO
    {
        $dto->code = Str::random(self::CODE_LENGTH);
        $dto->isEnabled = true;
        $dto->opensCount = 0;

        $dto = $this->databaseRepository->create($dto);
        $this->cacheRepository->resetCacheForFile($dto->fileId);

        return $dto;
    }
}
