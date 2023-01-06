<?php

namespace App\Models\Link\DTO;

use App\Models\Common\DTO\ModelDTO;

/**
 * Class LinkDTO
 * @package App\Models\Link\DTO
 */
final class LinkDTO extends ModelDTO
{
    /**
     * Link id value
     * @var int
     */
    public int $id;

    /**
     * File id value
     * @var int
     */
    public int $fileId;

    /**
     * Link type id value
     * @var int
     */
    public int $typeId;

    /**
     * Link code value
     * @var string
     */
    public string $code;

    /**
     * Link expired at value
     * @var string|null
     */
    public string|null $expiredAt = null;

    /**
     * Link is enabled flag value
     * @var bool
     */
    public bool $isEnabled;

    /**
     * Link opens count value
     * @var int
     */
    public int $opensCount;

    /**
     * Get link type
     *
     * @return array|null
     */
    public function getType(): ?array
    {
        foreach (config('handbooks.linkTypes') as $linkType) {
            if ($linkType['id'] === $this->typeId) {
                return $linkType;
            }
        }

        return null;
    }

    /**
     * Get URL for downloading file
     *
     * @return string
     */
    public function getUrl(): string
    {
        return route('api.v1.files.download', ['linkCode' => $this->code]);
    }
}
