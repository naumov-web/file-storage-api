<?php

namespace App\UseCases\File;

use App\Models\Common\DTO\ListDTO;
use App\Models\File\Contracts\IFileService;
use App\Models\File\DTO\GetUserFilesDTO;
use App\UseCases\BaseUseCase;
use App\UseCases\File\InputDTO\GetUserFilesInputDTO;

/**
 * Class GetUserFilesUseCase
 * @package App\UseCases\File
 */
final class GetUserFilesUseCase extends BaseUseCase
{
    /**
     * List instance
     * @var ListDTO
     */
    private ListDTO $list;

    /**
     * GetUserFilesUseCase constructor
     * @param IFileService $fileService
     */
    public function __construct(private IFileService $fileService) {}

    /**
     * Get list instance
     *
     * @return ListDTO
     */
    public function getList(): ListDTO
    {
        return $this->list;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $dto = new GetUserFilesDTO();
        $dto->userOwnerId = $this->inputDto->user->id;
        $dto->limit = $this->inputDto->limit ?? null;
        $dto->offset = $this->inputDto->offset ?? null;
        $dto->sortBy = $this->inputDto->sortBy ?? null;
        $dto->sortDirection = $this->inputDto->sortDirection ?? null;

        $this->list = $this->fileService->getUserFileList($dto);
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return GetUserFilesInputDTO::class;
    }
}
