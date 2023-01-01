<?php

namespace App\Http\Requests\Api\V1\Invitations;

use App\Http\Requests\Api\BaseApiRequest;

/**
 * Class ConfirmInvitationRequest
 * @package App\Http\Requests\Api\V1\Invitations
 *
 * @property string $code
 */
final class ConfirmInvitationRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string'
            ]
        ];
    }
}
