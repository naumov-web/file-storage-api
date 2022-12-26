<?php

namespace App\Http\Resources\Api\V1\User;

use App\Http\Resources\Api\BaseApiResource;
use App\Http\Resources\Api\V1\Role\RoleResource;
use Illuminate\Http\Request;

/**
 * Class UserResource
 * @package App\Http\Resources\Api\V1\User
 */
final class UserResource extends BaseApiResource
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
            'email' => $this->email,
            'name' => $this->name,
            'roles' => RoleResource::collection($this->roles),
        ];
    }
}
