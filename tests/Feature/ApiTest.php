<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_api_menu_returns_categories_and_cta(): void
    {
        $response = $this->getJson('/api/menu');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'agency',
                'cta' => ['text', 'url', 'target'],
                'categories' => [
                    '*' => [
                        'id',
                        'name',
                        'slug',
                        'sub_categories',
                    ],
                ],
            ]);

        $this->assertGreaterThanOrEqual(5, count($response->json('categories')));
    }

    public function test_api_search_finds_relevant_results(): void
    {
        $response = $this->getJson('/api/search?q=cloud');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'query',
                'total',
                'results' => [
                    'categories',
                    'sub_categories',
                    'articles',
                ],
            ]);

        $this->assertGreaterThan(0, $response->json('total'));
    }

    public function test_consultation_form_validation_rejects_empty_payload(): void
    {
        $response = $this->postJson('/api/consultations', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'message']);
    }

    public function test_consultation_form_accepts_valid_submission(): void
    {
        $payload = [
            'name' => 'Sarah Connor',
            'email' => 'sarah@skynet-defense.com',
            'phone' => '+1 555 0199',
            'company' => 'Cyberdyne Systems',
            'service_interest' => 'AI Engineering & Intelligent Agents',
            'budget' => '$100,000+',
            'timeline' => 'Immediate',
            'message' => 'We need an autonomous AI model validation pipeline with high-throughput inference.',
        ];

        $response = $this->postJson('/api/consultations', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('consultations', [
            'email' => 'sarah@skynet-defense.com',
            'name' => 'Sarah Connor',
        ]);
    }
}
