<?php

namespace App\Http\Resources\Api\V1\File;

use App\Http\Resources\Api\BaseApiResource;
use App\Http\Resources\Api\V1\Link\LinkResource;
use Illuminate\Http\Request;

/**
 * Class FileResource
 * @package App\Http\Resources\Api\V1\File
 */
final class FileResource extends BaseApiResource
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
            'mime' => $this->mime,
            'size' => $this->size,
            'description' => $this->description,
            'links' => LinkResource::collection(
                $this->links
            )
        ];
    }
}
