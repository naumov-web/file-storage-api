<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\BaseApiRequest;

/**
 * Class BaseListApiRequest
 * @package App\Http\Requests\Api\V1
 *
 * @property int|null $limit
 * @property int|null $offset
 * @property string|null $sortBy
 * @property string|null $sortDirection
 */
abstract class BaseListApiRequest extends BaseApiRequest
{
    /**
     * Compose request rules for getting of entities
     *
     * @param array $columns
     * @return array
     */
    protected function composeListRules(array $columns = ['id']): array
    {
        $result = [
            'limit' => [
                'nullable',
                'integer'
            ],
            'offset' => [
                'nullable',
                'integer'
            ]
        ];

        if ($columns) {
            $result = array_merge(
                $result,
                [
                    'sortBy' => [
                        'required_with:sortDirection',
                        'in:' . implode(',', $columns)
                    ],
                    'sortDirection' => [
                        'required_with:sortBy',
                        'in:asc,desc'
                    ]
                ]
            );
        }

        return $result;
    }
}
