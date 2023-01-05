<?php

namespace App\UseCases\Link;

use App\Models\File\Contracts\IFileCacheRepository;
use App\Models\Link\Contracts\ILinkService;
use App\UseCases\BaseUseCase;

/**
 * Class ClearExpiredTemporaryLinksUseCase
 * @package App\UseCases\Link
 */
final class ClearExpiredTemporaryLinksUseCase extends BaseUseCase
{
    /**
     * ClearExpiredTemporaryLinksUseCase constructor
     * @param ILinkService $linkService
     * @param IFileCacheRepository $cacheRepository
     */
    public function __construct(
        private ILinkService $linkService,
        private IFileCacheRepository $cacheRepository
    ) {}

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $fileIds = $this->linkService->removeExpiredTemporaryLinks();
        $this->cacheRepository->resetCacheForFiles($fileIds);
    }
}
