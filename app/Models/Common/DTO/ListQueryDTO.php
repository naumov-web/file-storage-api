<?php

namespace App\Models\Common\DTO;

/**
 * Class ListQueryDTO
 * @package App\Models\Common\DTO
 */
final class ListQueryDTO
{
    /**
     * Limit value
     * @var int|null
     */
    public int|null $limit;

    /**
     * Offset value
     * @var int|null
     */
    public int|null $offset;

    /**
     * Sort by value
     * @var string|null
     */
    public string|null $sortBy;

    /**
     * Sort direction value
     * @var string|null
     */
    public string|null $sortDirection;
}
