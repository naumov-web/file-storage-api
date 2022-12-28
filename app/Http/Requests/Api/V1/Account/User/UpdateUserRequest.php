<?php

namespace App\Http\Requests\Api\V1\Account\User;

use App\Http\Requests\Api\BaseApiRequest;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests\Api\V1\Account\User
 *
 * @property string $name
 * @property string|null $password
 */
final class UpdateUserRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'password' => [
                'nullable',
                'string',
            ],
        ];
    }
}
