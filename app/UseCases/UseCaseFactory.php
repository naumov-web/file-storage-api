<?php

namespace App\UseCases;

use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class UseCaseFactory
 * @package App\UseCases
 */
final class UseCaseFactory
{
    /**
     * Create use case instance
     *
     * @param string $systemName
     * @return BaseUseCase
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function createUseCase(string $systemName): BaseUseCase
    {
        $mapping = config('use_cases.mapping');

        if (!isset($mapping[$systemName])) {
            throw new UseCaseNotFoundException();
        }

        $className = $mapping[$systemName];
        $instance = app()->make($className);

        return $instance;
    }
}
