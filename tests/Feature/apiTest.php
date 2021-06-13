<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class apiTest extends TestCase
{
    /** @test */
    public function test_example()
    {
        $response = $this->get(route('test'));

        dd($response);

        $response->assertStatus(200);
    }
}
