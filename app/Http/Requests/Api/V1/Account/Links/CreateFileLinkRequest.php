<?php

namespace App\Http\Requests\Api\V1\Account\Links;

use App\Http\Requests\Api\BaseApiRequest;
use App\Models\Link\Enums\TypesEnum;
use App\ValidationRules\DateTimeNotInPast;

/**
 * Class CreateFileLinkRequest
 * @package App\Http\Requests\Api\V1\Account\Links
 *
 * @property int $typeId
 * @property string|null $expiredAt
 */
final class CreateFileLinkRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'typeId' => [
                'required',
                'integer'
            ],
            'expiredAt' => [
                'required_if:typeId,' . TypesEnum::TEMPORARY,
                'string',
                'date_format:Y-m-d H:i:s',
                new DateTimeNotInPast()
            ]
        ];
    }
}
