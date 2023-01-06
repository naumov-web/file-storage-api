<?php

namespace App\Http\Resources\Api\V1\Link;

use App\Http\Resources\Api\BaseApiResource;
use Illuminate\Http\Request;

/**
 * Class LinkResource
 * @package App\Http\Resources\Api\V1\Link
 */
final class LinkResource extends BaseApiResource
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
            'type' => $this->getType(),
            'url' => $this->getUrl(),
            'expiredAt' => $this->expiredAt,
            'isEnabled' => $this->isEnabled,
        ];
    }
}
