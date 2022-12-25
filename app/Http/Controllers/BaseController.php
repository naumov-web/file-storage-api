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
}
