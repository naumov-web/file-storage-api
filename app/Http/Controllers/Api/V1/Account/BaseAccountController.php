<?php

namespace App\Http\Controllers\Api\V1\Account;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class BaseAccountController
 * @package App\Http\Controllers\Api\V1\Account
 */
abstract class BaseAccountController extends BaseController
{
    /**
     * Get response with info about "Forbidden" status
     *
     * @return JsonResponse
     */
    protected function getFileForbiddenResponse(): JsonResponse
    {
        return \response()->json(
            [
                'success' => false,
                'message' => __('messages.you_are_not_owner_of_the_file')
            ],
            Response::HTTP_FORBIDDEN
        );
    }
}
