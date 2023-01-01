<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\V1\Invitations\ConfirmInvitationRequest;
use App\Models\Invitation\Exceptions\InvitationDoesntExistException;
use App\Models\Invitation\Exceptions\InvitationExpiredException;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\Invitation\InputDTO\ConfirmInvitationInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

/**
 * Class InvitationsController
 * @package App\Http\Controllers\Api\V1
 */
final class InvitationsController extends BaseController
{
    /**
     * Handle request for confirmation of invitation
     *
     * @param ConfirmInvitationRequest $request
     * @return Application|RedirectResponse|Redirector
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function confirm(ConfirmInvitationRequest $request): Application|RedirectResponse|Redirector
    {
        $inputDto = new ConfirmInvitationInputDTO();
        $inputDto->code = $request->code;

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CONFIRM_INVITATION);
        $useCase->setInputDTO($inputDto);
        try {
            $useCase->execute();
        } catch (InvitationDoesntExistException) {
            return redirect($this->getRedirectToNotFoundLink());
        } catch (InvitationExpiredException) {
            return redirect($this->getRedirectToForbiddenLink());
        }

        return redirect($this->getRedirectToLoginLink());
    }

    /**
     * Get URL for redirect to log in URL
     *
     * @return string
     */
    private function getRedirectToLoginLink(): string
    {
        return config('app.frontend_url') . '/login';
    }

    /**
     * Get URL for redirect to page with error "Forbidden"
     *
     * @return string
     */
    private function getRedirectToForbiddenLink(): string
    {
        return config('app.frontend_url') . '/forbidden';
    }

    /**
     * Get URL for redirect to page with error "Not found"
     *
     * @return string
     */
    private function getRedirectToNotFoundLink(): string
    {
        return config('app.frontend_url') . '/not-found';
    }
}
