<?php

namespace App\Http\Controllers\Api\V1\Account;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\V1\Account\Files\CreateUserFileRequest;
use App\Models\File\Exceptions\FileAlreadyExistsException;
use App\Models\User\Model;
use App\UseCases\Common\DTO\FileDTO;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\File\InputDTO\CreateUserFileInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class FilesController
 * @package App\Http\Controllers\Api\V1\Account
 */
final class FilesController extends BaseController
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
         * @var Model $user
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
}
