<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class order extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_order_returns_a_successful_response(): void
    {
        
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
