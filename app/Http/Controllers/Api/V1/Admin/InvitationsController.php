<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\V1\Admin\Invitations\CreateInvitationRequest;
use App\Models\Invitation\Exceptions\InvitationForEmailAlreadyExistsException;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\Invitation\InputDTO\CreateInvitationInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class InvitationsController
 * @package App\Http\Controllers\Api\V1\Admin
 */
final class InvitationsController extends BaseController
{
    /**
     * Handle request for creation of invitation
     *
     * @param CreateInvitationRequest $request
     * @return JsonResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function create(CreateInvitationRequest $request): JsonResponse
    {
        $inputDto = new CreateInvitationInputDTO();
        $inputDto->email = $request->email;
        $inputDto->name = $request->name;
        $inputDto->password = $request->password;
        $inputDto->expiredAt = $request->expiredAt;

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_INVITATION);
        $useCase->setInputDTO($inputDto);

        try {
            $useCase->execute();
        } catch (InvitationForEmailAlreadyExistsException) {
            return response()->json(
                [
                    'errors' => [
                        'email' => [

                        ]
                    ]
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return response()->json([
            'success' => true,
            'message' => __('messages.invitation_successfully_created')
        ]);
    }
}
