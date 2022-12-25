<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Http\Requests\Api\BaseApiRequest;

/**
 * Class LoginRequest
 * @package App\Http\Requests\Api\V1\Auth
 *
 * @property string $email
 * @property string $password
 */
final class LoginRequest extends BaseApiRequest
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
                'email'
            ],
            'password' => [
                'required',
                'string',
            ],
        ];
    }
}
