<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Test the landing page loads successfully.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Mahishika');
        $response->assertSee('Services');
        $response->assertSee('Industries');
        $response->assertSee('Work');
        $response->assertSee('Approach');
        $response->assertSee('About');
        $response->assertSee('Book a Consultation');
    }
}
