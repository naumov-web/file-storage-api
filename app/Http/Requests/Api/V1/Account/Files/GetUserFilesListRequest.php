<?php

namespace App\Http\Requests\Api\V1\Account\Files;

use App\Http\Requests\Api\V1\BaseListApiRequest;

/**
 * Class GetUserFilesListRequest
 * @package App\Http\Requests\Api\V1\Account\Files
 */
final class GetUserFilesListRequest extends BaseListApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->composeListRules([
            'id',
            'name',
            'mime',
            'size',
            'description'
        ]);
    }
}
