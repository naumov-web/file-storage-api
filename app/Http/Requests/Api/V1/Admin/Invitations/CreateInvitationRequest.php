<?php

namespace App\Http\Requests\Api\V1\Admin\Invitations;

use App\Http\Requests\Api\BaseApiRequest;
use App\ValidationRules\DateTimeNotInPast;

/**
 * Class CreateInvitationRequest
 * @package App\Http\Requests\Api\V1\Admin\Invitations
 *
 * @property string $email
 * @property string $name
 * @property string|null $password
 * @property string $expiredAt
 */
final class CreateInvitationRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
            ],
            'name' => [
                'required',
                'string',
            ],
            'password' => [
                'nullable',
                'string',
            ],
            'expiredAt' => [
                'required',
                'string',
                'date_format:Y-m-d H:i:s',
                new DateTimeNotInPast()
            ],
        ];
    }
}
