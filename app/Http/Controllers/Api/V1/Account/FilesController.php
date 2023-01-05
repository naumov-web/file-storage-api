<?php

namespace App\Http\Controllers\Api\V1\Account;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Requests\Api\V1\Account\Files\CreateUserFileRequest;
use App\Models\File\Exceptions\FileAlreadyExistsException;
use App\Models\User;
use App\Models\File;
use App\UseCases\Common\DTO\FileDTO;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\File\InputDTO\CreateUserFileInputDTO;
use App\UseCases\File\InputDTO\DeleteUserFileInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class FilesController
 * @package App\Http\Controllers\Api\V1\Account
 */
final class FilesController extends BaseAccountController
{
    /**
     * Handle request for creation of file for current user
     *
     * @param CreateUserFileRequest $request
     * @return JsonResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function create(CreateUserFileRequest $request): JsonResponse
    {
        /**
         * @var User\Model $user
         */
        $user = auth()->user();
        $inputDto = new CreateUserFileInputDTO();
        $inputDto->user = $user;
        $inputDto->description = $request->description;
        $inputDto->file = new FileDTO();
        $inputDto->file->name = $request->file['name'];
        $inputDto->file->mime = $request->file['mime'];
        $inputDto->file->content = $request->file['content'];

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_USER_FILE);
        $useCase->setInputDTO($inputDto);
        try {
            $useCase->execute();
        } catch (FileAlreadyExistsException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => __('messages.file_already_exists')
                ],
                Response::HTTP_FORBIDDEN
            );
        }


        return response()->json([
            'success' => true,
            'message' => __('messages.file_successfully_created')
        ]);
    }

    /**
     * Handle request for deleting of specific file
     *
     * @param File\Model $file
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function delete(File\Model $file): JsonResponse
    {
        /**
         * @var User\Model $user
         */
        $user = auth()->user();

        $inputDto = new DeleteUserFileInputDTO();
        $inputDto->id = $file->id;
        $inputDto->userOwnerId = $user->id;

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::DELETE_USER_FILE);
        $useCase->setInputDTO($inputDto);
        try {
            $useCase->execute();
        } catch (File\Exceptions\FileForbiddenException) {
            return $this->getFileForbiddenResponse();
        }

        return \response()->json([
            'success' => true,
            'message' => __('messages.file_successfully_deleted')
        ]);
    }
}
