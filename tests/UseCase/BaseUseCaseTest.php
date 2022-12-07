<?php

namespace Tests\UseCase;

use App\UseCases\UseCaseFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class BaseUseCaseTest
 * @package Tests\UseCase
 */
abstract class BaseUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected UseCaseFactory $useCaseFactory;

    /**
     * Prepare before testing
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->useCaseFactory = new UseCaseFactory();
    }
}
