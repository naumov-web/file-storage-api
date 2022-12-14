<?php

namespace App\UseCases\File;

use App\Models\File\Contracts\IFileService;
use App\Models\File\DTO\FileDTO;
use App\Models\File\Exceptions\FileAlreadyExistsException;
use App\UseCases\BaseUseCase;
use App\UseCases\File\InputDTO\CreateUserFileInputDTO;

/**
 * Class CreateUserFileUseCase
 * @package App\UseCases\File
 */
final class CreateUserFileUseCase extends BaseUseCase
{
    /**
     * CreateUserFileUseCase constructor
     * @param IFileService $fileService
     */
    public function __construct(private IFileService $fileService) {}

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return CreateUserFileInputDTO::class;
    }

    /**
     * @inheritDoc
     * @throws FileAlreadyExistsException
     */
    public function execute(): void
    {
        /**
         * @var CreateUserFileInputDTO $inputDto
         */
        $inputDto = $this->inputDto;

        $filePathDto = $this->fileService->saveContentToFile($inputDto->file->name, $inputDto->file->content);

        $fileDto = new FileDTO();
        $fileDto->userOwnerId = $inputDto->user->id;
        $fileDto->name = $inputDto->file->name;
        $fileDto->mime = $inputDto->file->mime;
        $fileDto->size = $filePathDto->size;
        $fileDto->path = $filePathDto->path;
        $fileDto->sha1 = $filePathDto->sha1;
        $fileDto->description = $inputDto->description;

        try {
            $this->fileService->create($fileDto);
        } catch (FileAlreadyExistsException $exception) {
            $this->fileService->deleteFileByPath($fileDto->path);
            throw $exception;
        }
    }
}
