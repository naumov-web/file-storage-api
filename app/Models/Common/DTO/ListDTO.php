<?php

namespace App\Models\Common\DTO;

use Illuminate\Support\Collection;

/**
 * Class ListDTO
 * @package App\Models\Common\DTO
 */
final class ListDTO
{
    /**
     * Items collection
     * @var Collection
     */
    public Collection $items;

    /**
     * Total count value
     * @var int
     */
    public int $count;
}
