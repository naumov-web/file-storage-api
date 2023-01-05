<?php

namespace App\Models\Link\Services;

use App\Models\Link\Contracts\ILinkCacheRepository;
use App\Models\Link\Contracts\ILinkDatabaseRepository;
use App\Models\Link\Contracts\ILinkService;
use App\Models\Link\DTO\LinkDTO;
use App\Models\Link\Enums\TypesEnum;
use App\Models\Link\Exceptions\LinkDoesntExistException;
use App\Models\Link\Exceptions\LinkExpiredException;
use App\Models\Link\Exceptions\PermanentLinkAlreadyExistsException;
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
     * @throws PermanentLinkAlreadyExistsException
     */
    public function create(LinkDTO $dto): LinkDTO
    {
        if ($dto->typeId === TypesEnum::PERMANENT) {
            $links = $this->cacheRepository->getLinks($dto->fileId);

            foreach ($links as $link) {
                /**
                 * @var LinkDTO $link
                 */
                if ($link->typeId === TypesEnum::PERMANENT) {
                    throw new PermanentLinkAlreadyExistsException();
                }
            }

            $dto->expiredAt = null;
        }

        $dto->code = Str::random(self::CODE_LENGTH);
        $dto->isEnabled = true;
        $dto->opensCount = 0;

        $dto = $this->databaseRepository->create($dto);
        $this->cacheRepository->resetCacheForFile($dto->fileId);

        return $dto;
    }

    /**
     * @inheritDoc
     */
    public function removeExpiredTemporaryLinks(): array
    {
        $fileIds = $this->databaseRepository->removeExpiredTemporaryLinks();
        $this->cacheRepository->resetCacheForFiles($fileIds);

        return $fileIds;
    }

    /**
     * @inheritDoc
     */
    public function getLinkByCode(string $code): LinkDTO
    {
        $linkDto = $this->cacheRepository->getLinkByCode($code);

        if (!$linkDto) {
            throw new LinkDoesntExistException();
        }

        $now = time();

        if (
            $linkDto->typeId === TypesEnum::TEMPORARY &&
            strtotime($linkDto->expiredAt) < $now
        ) {
            throw new LinkExpiredException();
        }

        return $linkDto;
    }

    /**
     * @inheritDoc
     */
    public function incrementOpensCount(LinkDTO $dto): void
    {
        $this->databaseRepository->incrementOpensCount($dto);
    }
}
