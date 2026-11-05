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

    public function test_admin_can_toggle_category_status(): void
    {
        $category = Category::first();
        $initialStatus = $category->is_active;

        $response = $this->patch("/admin/categories/{$category->id}/toggle-status");
        $response->assertRedirect('/admin/categories');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'is_active' => !$initialStatus,
        ]);
    }

    public function test_admin_can_toggle_category_status_via_ajax(): void
    {
        $category = Category::first();
        $initialStatus = $category->is_active;

        $response = $this->patchJson("/admin/categories/{$category->id}/toggle-status");
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'is_active' => !$initialStatus,
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'is_active' => !$initialStatus,
        ]);
    }

    public function test_admin_can_toggle_subcategory_status(): void
    {
        $sub = SubCategory::first();
        $initialStatus = $sub->is_active;

        $response = $this->patchJson("/admin/subcategories/{$sub->id}/toggle-status");
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'is_active' => !$initialStatus,
            ]);

        $this->assertDatabaseHas('sub_categories', [
            'id' => $sub->id,
            'is_active' => !$initialStatus,
        ]);
    }

    public function test_admin_can_toggle_portfolio_status_and_featured(): void
    {
        $item = PortfolioArticle::first();
        $initialStatus = $item->is_active;
        $initialFeatured = $item->is_featured;

        // Toggle active status
        $responseStatus = $this->patchJson("/admin/portfolio/{$item->id}/toggle-status");
        $responseStatus->assertStatus(200)
            ->assertJson([
                'success' => true,
                'is_active' => !$initialStatus,
            ]);

        // Toggle featured
        $responseFeat = $this->patchJson("/admin/portfolio/{$item->id}/toggle-featured");
        $responseFeat->assertStatus(200)
            ->assertJson([
                'success' => true,
                'is_featured' => !$initialFeatured,
            ]);

        $this->assertDatabaseHas('portfolio_articles', [
            'id' => $item->id,
            'is_active' => !$initialStatus,
            'is_featured' => !$initialFeatured,
        ]);
    }

    public function test_subcategories_pagination_renders_bootstrap_without_giant_svg(): void
    {
        $response = $this->get('/admin/subcategories');
        $response->assertStatus(200);

        // Subcategories has 24 seeded items with paginate(15) -> 2 pages
        // Must contain standard Bootstrap 5 pagination classes and no unstyled tailwind classes
        $content = $response->getContent();
        $this->assertStringContainsString('pagination', $content);
        $this->assertStringContainsString('page-item', $content);
        $this->assertStringContainsString('page-link', $content);
        // Ensure no unstyled Tailwind flex-1 or svg without dimensions
        $this->assertStringNotContainsString('sm:hidden', $content);
        $this->assertStringNotContainsString('hidden sm:flex-1', $content);
    }

    public function test_admin_pages_render_status_confirmation_modal(): void
    {
        $response = $this->get('/admin/categories');
        $response->assertStatus(200);

        $content = $response->getContent();
        $this->assertStringContainsString('id="statusConfirmModal"', $content);
        $this->assertStringContainsString('id="statusConfirmOkBtn"', $content);
        $this->assertStringContainsString('id="statusConfirmCancelBtn"', $content);
        $this->assertStringContainsString('admin-status-toggle', $content);
    }
}

