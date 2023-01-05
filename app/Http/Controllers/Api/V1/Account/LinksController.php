<?php

namespace App\Http\Controllers\Api\V1\Account;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Requests\Api\V1\Account\Links\CreateFileLinkRequest;
use App\Models\File;
use App\Models\Link\Exceptions\FileForbiddenException;
use App\Models\Link\Exceptions\PermanentLinkAlreadyExistsException;
use App\Models\User;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\Link\CreateFileLinkUseCase;
use App\UseCases\Link\InputDTO\CreateFileLinkInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class LinksController
 * @package App\Http\Controllers\Api\V1\Account
 */
final class LinksController extends BaseAccountController
{
    /**
     * Create link for specific file
     *
     * @param CreateFileLinkRequest $request
     * @param File\Model $file
     * @return JsonResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function create(CreateFileLinkRequest $request, File\Model $file): JsonResponse
    {
        /**
         * @var User\Model $user
         */
        $user = auth()->user();
        $inputDto = new CreateFileLinkInputDTO();
        $inputDto->fileId = $file->id;
        $inputDto->userOwnerId = $user->id;
        $inputDto->typeId = $request->typeId;
        $inputDto->expiredAt = $request->expiredAt;

        /**
         * @var CreateFileLinkUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_FILE_LINK);
        $useCase->setInputDTO($inputDto);
        try {
            $useCase->execute();
        } catch (FileForbiddenException) {
            return $this->getFileForbiddenResponse();
        } catch (PermanentLinkAlreadyExistsException) {
            return \response()->json(
                [
                    'success' => false,
                    'message' => __('messages.permanent_link_already_exists')
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        $linkDto = $useCase->getLinkDto();

        return response()->json([
            'success' => true,
            'message' => __('messages.link_successfully_created'),
            'url' => $linkDto->getUrl()
        ]);
    }
}
