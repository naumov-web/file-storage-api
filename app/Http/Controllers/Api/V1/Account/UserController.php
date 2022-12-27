<?php

namespace App\Http\Controllers\Api\V1\Account;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Api\V1\User\UserResource;
use App\Models\User\Model;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\User\GetUserUseCase;
use App\UseCases\User\InputDTO\GetUserInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

/**
 * Class UserController
 * @package App\Http\Controllers\Api\V1\Account
 */
final class UserController extends BaseController
{
    /**
     * Handle request for getting of current user
     *
     * @return JsonResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function getCurrent(): JsonResponse
    {
        /**
         * @var Model $user
         */
        $user = auth()->user();
        $inputDto = new GetUserInputDTO();
        $inputDto->user = $user;

        /**
         * @var GetUserUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_USER);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        $userDto = $useCase->getUserDto();

        return response()->json([
            'success' => true,
            'message' => __('messages.user_successfully_loaded'),
            'user' => new UserResource($userDto)
        ]);
    }
}
