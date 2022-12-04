<?php

namespace App\Models\Common\Repositories;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class BaseDatabaseRepository
 * @package App\Models\Common\Repositories
 */
abstract class BaseDatabaseRepository
{
    /**
     * Get model class name
     *
     * @return string
     */
    abstract protected function getModelsClass(): string;

    /**
     * Get query builder instance
     *
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        $className = $this->getModelsClass();
        /**
         * @var Builder $query
         */
        $query = $className::query();

        return $query;
    }
}
