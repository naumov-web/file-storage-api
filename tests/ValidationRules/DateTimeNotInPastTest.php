<?php

namespace Tests\ValidationRules;

use App\ValidationRules\DateTimeNotInPast;
use Tests\TestCase;

/**
 * Class DateTimeNotInPastTest
 * @package Tests\ValidationRules
 */
final class DateTimeNotInPastTest extends TestCase
{
    /**
     * Test case, when we try to check empty datetime
     *
     * @test
     * @return void
     */
    public function testEmptyDateTime(): void
    {
        $validator = new DateTimeNotInPast();
        $this->assertTrue(
            $validator->passes(
                'datetime',
                null
            )
        );
    }

    /**
     * Test case, when we try to check valid datetime
     *
     * @test
     * @return void
     */
    public function testValidDateTime(): void
    {
        $validator = new DateTimeNotInPast();
        $this->assertTrue(
            $validator->passes(
                'datetime',
                date('Y-m-d H:i:s', time() + 3600)
            )
        );
    }

    /**
     * Test case, when we try to check invalid datetime
     *
     * @test
     * @return void
     */
    public function testInvalidDateTime(): void
    {
        $validator = new DateTimeNotInPast();
        $this->assertFalse(
            $validator->passes(
                'datetime',
                date('Y-m-d H:i:s', time() - 3600)
            )
        );
    }
}
