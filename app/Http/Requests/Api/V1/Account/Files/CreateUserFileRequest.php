<?php

namespace App\Http\Requests\Api\V1\Account\Files;

use App\Http\Requests\Api\BaseApiRequest;

/**
 * Class CreateUserFileRequest
 * @package App\Http\Requests\Api\V1\Account\Files
 *
 * @property array $file
 * @property string|null $description
 */
final class CreateUserFileRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'array'
            ],
            'file.name' => [
                'required',
                'string'
            ],
            'file.mime' => [
                'required',
                'string'
            ],
            'file.content' => [
                'required',
                'string'
            ],
            'description' => [
                'nullable',
                'string'
            ]
        ];
    }
}
