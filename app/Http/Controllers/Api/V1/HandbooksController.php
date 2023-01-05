<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\BaseController;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\Handbook\GetHandbooksUseCase;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

/**
 * Class HandbooksController
 * @package App\Http\Controllers\Api\V1
 */
final class HandbooksController extends BaseController
{
    /**
     * Handle request for getting of handbooks
     *
     * @return JsonResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function index(): JsonResponse
    {
        /**
         * @var GetHandbooksUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_HANDBOOKS);
        $useCase->execute();
        $handbooksDto = $useCase->getResult();

        return response()->json([
            'success' => true,
            'message' => __('messages.handbooks_successfully_loaded'),
            'handbooks' => [
                'linkTypes' => $handbooksDto->linkTypes
            ]
        ]);
    }
}
