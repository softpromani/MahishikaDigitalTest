<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Consultation;
use App\Models\PortfolioArticle;
use App\Models\SubCategory;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $admin = User::where('email', 'admin@mahishika.digital')->first();
        $this->actingAs($admin);
    }

    public function test_admin_dashboard_loads_with_statistics(): void
    {
        $response = $this->get('/admin');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_category(): void
    {
        $payload = [
            'name' => 'Technologies',
            'slug' => 'technologies',
            'description' => 'Our modern tech stack',
            'icon' => 'bi-code',
            'badge' => 'New',
            'sort_order' => 6,
            'is_active' => '1',
        ];

        $response = $this->post('/admin/categories', $payload);
        $response->assertRedirect('/admin/categories');

        $this->assertDatabaseHas('categories', [
            'slug' => 'technologies',
            'name' => 'Technologies',
        ]);
    }

    public function test_admin_can_create_subcategory(): void
    {
        $services = Category::where('slug', 'services')->first();

        $payload = [
            'category_id' => $services->id,
            'title' => 'Blockchain & Smart Contracts',
            'slug' => 'blockchain-smart-contracts',
            'description' => 'Ethereum, Solana, and smart contract security audits.',
            'url' => '#services-blockchain',
            'icon' => 'bi-link-45deg',
            'badge' => 'Web3',
            'sort_order' => 7,
            'is_active' => '1',
        ];

        $response = $this->post('/admin/subcategories', $payload);
        $response->assertRedirect('/admin/subcategories?category_id=' . $services->id);

        $this->assertDatabaseHas('sub_categories', [
            'slug' => 'blockchain-smart-contracts',
            'title' => 'Blockchain & Smart Contracts',
        ]);
    }

    public function test_admin_can_create_portfolio_item(): void
    {
        $services = Category::where('slug', 'services')->first();

        $payload = [
            'category_id' => $services->id,
            'title' => 'Decentralized Treasury Scale',
            'slug' => 'decentralized-treasury-scale',
            'type' => 'case_study',
            'client_name' => 'Nexus Protocol',
            'excerpt' => 'Secured \$450M in TVL with audited multi-sig governance contracts.',
            'tag' => 'Web3 Security',
            'metric' => '$450M+',
            'metric_label' => 'Total Value Locked',
            'image_url' => 'https://images.unsplash.com/photo-1639762681485-074b7f938ba0?auto=format&fit=crop&w=700&q=80',
            'link_url' => '#work-nexus',
            'sort_order' => 5,
            'is_featured' => '1',
            'is_active' => '1',
        ];

        $response = $this->post('/admin/portfolio', $payload);
        $response->assertRedirect('/admin/portfolio');

        $this->assertDatabaseHas('portfolio_articles', [
            'slug' => 'decentralized-treasury-scale',
            'client_name' => 'Nexus Protocol',
        ]);
    }

    public function test_admin_can_update_consultation_status(): void
    {
        $lead = Consultation::first();

        $response = $this->put("/admin/consultations/{$lead->id}/status", [
            'status' => 'scheduled',
        ]);

        $response->assertRedirect('/admin/consultations');

        $this->assertDatabaseHas('consultations', [
            'id' => $lead->id,
            'status' => 'scheduled',
        ]);
    }

    public function test_admin_can_reply_to_consultation(): void
    {
        $lead = Consultation::where('status', 'new')->first();

        $response = $this->post("/admin/consultations/{$lead->id}/reply", [
            'subject' => 'Follow up on Cloud Project',
            'reply_message' => 'We would love to schedule a call.',
        ]);

        $response->assertRedirect('/admin/consultations');

        $this->assertDatabaseHas('consultations', [
            'id' => $lead->id,
            'status' => 'contacted',
        ]);
    }
}

