<?php

namespace App\UseCases\Common\DTO;

/**
 * Class BaseListUseCaseDTO
 * @package App\UseCases\Common\DTO
 */
abstract class BaseListUseCaseDTO extends BaseUseCaseDTO
{
    /**
     * Limit value
     * @var int|null
     */
    public int|null $limit = null;

    /**
     * Offset value
     * @var int|null
     */
    public int|null $offset = null;

    /**
     * Sort by value
     * @var string|null
     */
    public string|null $sortBy = null;

    /**
     * Sort direction value
     * @var string|null
     */
    public string|null $sortDirection = null;
}
