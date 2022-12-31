<?php

namespace Tests\UseCases;

use App\Models\Role\Model;
use App\UseCases\UseCaseFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

/**
 * Class BaseUseCaseTest
 * @package Tests\UseCase
 */
abstract class BaseUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Use case factory instance
     * @var UseCaseFactory
     */
    protected UseCaseFactory $useCaseFactory;

    /**
     * Roles data list
     * @var array
     */
    protected array $rolesData = [
        [
            'name' => 'Admin',
            'system_name' => 'admin'
        ],
        [
            'name' => 'User',
            'system_name' => 'user'
        ]
    ];

    /**
     * Prepare before testing
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        $this->useCaseFactory = new UseCaseFactory();
    }

    /**
     * Create roles
     *
     * @return void
     */
    protected function createRoles(): void
    {
        foreach ($this->rolesData as $roleData) {
            Model::query()->create($roleData);
        }
    }
}
