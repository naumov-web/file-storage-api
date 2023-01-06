<?php

namespace App\Http\Resources\Api\V1\Common;

use App\Http\Resources\Api\BaseApiResource;

/**
 * Class ListResource
 * @package App\Http\Resources\Api\V1\Common
 */
final class ListResource extends BaseApiResource
{
    /**
     * Message value
     * @var string
     */
    private string $message;

    /**
     * Resource class name value
     * @var string
     */
    private string $resourceClassName;

    /**
     * Convert object to array
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'success' => true,
            'message' => $this->message,
            'items' => $this->resourceClassName::collection($this->items),
            'count' => $this->count,
        ];
    }

    /**
     * Set message
     *
     * @param string $message
     * @return ListResource
     */
    public function setMessage(string $message): ListResource
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set resource class name
     *
     * @param string $resourceClassName
     * @return ListResource
     */
    public function setResourceClassName(string $resourceClassName): ListResource
    {
        $this->resourceClassName = $resourceClassName;

        return $this;
    }
}
