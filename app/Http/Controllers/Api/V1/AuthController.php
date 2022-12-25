<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\User\AuthorizeUserUseCase;
use App\UseCases\User\InputDTO\AuthorizeUserInputDTO;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api\V1
 */
final class AuthController extends BaseController
{
    /**
     * Handle request for login user
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $inputDto = new AuthorizeUserInputDTO();
        $inputDto->email = $request->email;
        $inputDto->password = $request->password;
        /**
         * @var AuthorizeUserUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::AUTHORIZE_USER);
        $useCase->setInputDTO($inputDto);
        try {
            $useCase->execute();
        } catch (AuthorizationException) {
            return response()->json([
                'success' => false,
                'message' => __('messages.incorrect_email_or_password'),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => __('messages.user_successfully_authorized'),
            'token' => $useCase->getToken()
        ]);
    }
}
