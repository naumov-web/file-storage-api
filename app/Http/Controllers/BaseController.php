<?php

namespace App\Http\Controllers;

use App\UseCases\UseCaseFactory;

/**
 * Class BaseController
 * @package App\Http\Controllers
 */
abstract class BaseController extends Controller
{
    /**
     * BaseController constructor
     * @param UseCaseFactory $useCaseFactory
     */
    public function __construct(protected UseCaseFactory $useCaseFactory) {}

    /**
     * Get URL for redirect to page with error "Forbidden"
     *
     * @return string
     */
    protected function getRedirectToForbiddenLink(): string
    {
        return config('app.frontend_url') . '/forbidden';
    }

    /**
     * Get URL for redirect to page with error "Not found"
     *
     * @return string
     */
    protected function getRedirectToNotFoundLink(): string
    {
        return config('app.frontend_url') . '/not-found';
    }
}
