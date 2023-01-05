<?php

namespace App\UseCases\File;

use App\Models\File\Contracts\IFileService;
use App\Models\Link\Contracts\ILinkService;
use App\UseCases\BaseUseCase;
use App\UseCases\File\InputDTO\GetFileByCodeInputDTO;

/**
 * Class GetFileByCodeUseCase
 * @package App\UseCases\File
 */
final class GetFileByCodeUseCase extends BaseUseCase
{
    /**
     * Full file path value
     * @var string
     */
    private string $fullFilePath;

    /**
     * GetFileByCodeUseCase constructor
     * @param ILinkService $linkService
     * @param IFileService $fileService
     */
    public function __construct(private ILinkService $linkService, private IFileService $fileService) {}

    /**
     * Get full file path value
     *
     * @return string
     */
    public function getFullFilePath(): string
    {
        return $this->fullFilePath;
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return GetFileByCodeInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $linkDto = $this->linkService->getLinkByCode($this->inputDto->linkCode);
        $this->fullFilePath = $this->fileService->getFileFullPath($linkDto->fileId);
        $this->linkService->incrementOpensCount($linkDto);
    }
}
