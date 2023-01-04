<?php

namespace App\UseCases\File;

use App\Models\File\Contracts\IFileService;
use App\UseCases\BaseUseCase;
use App\UseCases\File\InputDTO\DeleteUserFileInputDTO;

/**
 * Class DeleteUserFileUseCase
 * @package App\UseCases\File
 */
final class DeleteUserFileUseCase extends BaseUseCase
{
    /**
     * DeleteUserFileUseCase constructor
     * @param IFileService $service
     */
    public function __construct(private IFileService $service) {}

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return DeleteUserFileInputDTO::class;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $this->service->delete(
            $this->inputDto->id,
            $this->inputDto->userOwnerId
        );
    }
}
