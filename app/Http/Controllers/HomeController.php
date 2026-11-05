<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Consultation;
use App\Models\PortfolioArticle;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the Mahishika Digital services landing page.
     */
    public function index(): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->with([
                'subCategories' => function ($query) {
                    $query->where('is_active', true)->orderBy('sort_order', 'asc');
                },
                'portfolioArticles' => function ($query) {
                    $query->where('is_active', true)->orderBy('sort_order', 'asc');
                },
            ])
            ->get();

        $servicesCategory = $categories->firstWhere('slug', 'services');
        $industriesCategory = $categories->firstWhere('slug', 'industries');
        $workCategory = $categories->firstWhere('slug', 'work');
        $approachCategory = $categories->firstWhere('slug', 'approach');
        $aboutCategory = $categories->firstWhere('slug', 'about');

        $featuredCaseStudies = PortfolioArticle::query()
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order', 'asc')
            ->limit(4)
            ->get();

        $allServices = $servicesCategory ? $servicesCategory->subCategories : collect();
        $allIndustries = $industriesCategory ? $industriesCategory->subCategories : collect();

        $stats = [
            ['value' => '99.99%', 'label' => 'Production Uptime SLA', 'sub' => 'Guaranteed on high-load architectures'],
            ['value' => '120+', 'label' => 'Global Deployments', 'sub' => 'Across FinTech, HealthTech & SaaS'],
            ['value' => '14 Days', 'label' => 'Time-to-Production Deploy', 'sub' => 'Disciplined two-week agile sprint cycles'],
            ['value' => '4.9 / 5', 'label' => 'Client Satisfaction CSAT', 'sub' => 'Verified enterprise partner NPS'],
        ];

        return view('landing', compact(
            'categories',
            'servicesCategory',
            'industriesCategory',
            'workCategory',
            'approachCategory',
            'aboutCategory',
            'allServices',
            'allIndustries',
            'featuredCaseStudies',
            'stats'
        ));
    }
}
