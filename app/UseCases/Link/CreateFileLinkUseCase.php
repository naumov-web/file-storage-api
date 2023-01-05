<?php

namespace App\UseCases\Link;

use App\Models\File\Contracts\IFileCacheRepository;
use App\Models\Link\Contracts\ILinkService;
use App\Models\Link\DTO\LinkDTO;
use App\Models\Link\Exceptions\FileForbiddenException;
use App\UseCases\BaseUseCase;
use App\UseCases\Link\InputDTO\CreateFileLinkInputDTO;

/**
 * Class CreateFileLinkUseCase
 * @package App\UseCases\Link
 */
final class CreateFileLinkUseCase extends BaseUseCase
{
    /**
     * Link DTO instance
     * @var LinkDTO
     */
    private LinkDTO $linkDto;

    /**
     * CreateFileLinkUseCase constructor
     * @param IFileCacheRepository $fileCacheRepository
     * @param ILinkService $linkService
     */
    public function __construct(
        private IFileCacheRepository $fileCacheRepository,
        private ILinkService $linkService
    ) {}

    /**
     * Get link DTO instance
     *
     * @return LinkDTO
     */
    public function getLinkDto(): LinkDTO
    {
        return $this->linkDto;
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return CreateFileLinkInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $fileDto = $this->fileCacheRepository->getFileForOwner(
            $this->inputDto->fileId,
            $this->inputDto->userOwnerId
        );

        if (!$fileDto) {
            throw new FileForbiddenException();
        }

        $dto = new LinkDTO();
        $dto->fileId = $this->inputDto->fileId;
        $dto->typeId = $this->inputDto->typeId;
        $dto->expiredAt = $this->inputDto->expiredAt;

        $this->linkDto = $this->linkService->create($dto);
    }
}
