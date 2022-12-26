<?php

namespace App\Http\Resources\Api\V1\Role;

use App\Http\Resources\Api\BaseApiResource;
use Illuminate\Http\Request;

/**
 * Class RoleResource
 * @package App\Http\Resources\Api\V1\Role
 */
final class RoleResource extends BaseApiResource
{
    /**
     * Convert object to array
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'systemName' => $this->system_name,
        ];
    }
}
