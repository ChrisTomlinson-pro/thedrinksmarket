<?php

namespace Tests\Feature\Square;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SyncProductsTest extends TestCase
{
    /** @test */
    public function test_example()
    {
        $response = $this->get(route('square-sync-items'));

        $response->assertStatus(201);
    }
}
