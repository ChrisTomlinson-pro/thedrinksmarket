<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetItemsTest extends TestCase
{
    /** @test */
    public function test_example()
    {
        $response = $this->get(route('get-items'));
        dd($response);

        $response->assertStatus(200);
    }
}
