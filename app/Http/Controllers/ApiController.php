<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Consultation;
use App\Models\PortfolioArticle;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    /**
     * Return hierarchical mega menu navigation structure.
     */
    public function menu(): JsonResponse
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

        return response()->json([
            'success' => true,
            'agency' => 'Mahishika Digital',
            'cta' => [
                'text' => 'Book a Consultation',
                'url' => '#consultation-modal',
                'target' => '_modal',
            ],
            'categories' => $categories,
        ]);
    }

    /**
     * Search across categories, subcategories, and portfolio articles.
     */
    public function search(Request $request): JsonResponse
    {
        $query = trim($request->input('q', ''));

        if (mb_strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'query' => $query,
                'results' => [],
                'message' => 'Please enter at least 2 characters to search.',
            ]);
        }

        $categories = Category::query()
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get(['id', 'name', 'slug', 'description', 'icon', 'badge']);

        $subCategories = SubCategory::query()
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->with('category:id,name,slug')
            ->limit(8)
            ->get(['id', 'category_id', 'title', 'slug', 'description', 'url', 'icon', 'badge']);

        $articles = PortfolioArticle::query()
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('tag', 'like', "%{$query}%")
                  ->orWhere('client_name', 'like', "%{$query}%");
            })
            ->limit(6)
            ->get(['id', 'title', 'slug', 'type', 'client_name', 'excerpt', 'tag', 'metric', 'metric_label', 'link_url']);

        $totalCount = $categories->count() + $subCategories->count() + $articles->count();

        return response()->json([
            'success' => true,
            'query' => $query,
            'total' => $totalCount,
            'results' => [
                'categories' => $categories,
                'sub_categories' => $subCategories,
                'articles' => $articles,
            ],
        ]);
    }

    /**
     * Store new consultation booking.
     */
    public function storeConsultation(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'company' => 'nullable|string|max:100',
            'service_interest' => 'nullable|string|max:100',
            'budget' => 'nullable|string|max:50',
            'timeline' => 'nullable|string|max:50',
            'message' => 'required|string|min:10|max:3000',
        ], [
            'name.required' => 'Please provide your full name.',
            'email.required' => 'A valid work email address is required.',
            'email.email' => 'Please provide a valid email address format.',
            'message.required' => 'Please describe your project or consultation request.',
            'message.min' => 'Please provide at least 10 characters describing your project.',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed. Please correct the highlighted errors.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = mb_substr((string) $request->userAgent(), 0, 500);
        $validated['status'] = 'new';

        $consultation = Consultation::create($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for reaching out! A senior solutions architect from Mahishika Digital will review your requirements and reach out within 24 business hours.',
                'consultation_id' => $consultation->id,
                'data' => [
                    'name' => $consultation->name,
                    'service' => $consultation->service_interest,
                    'created_at' => $consultation->created_at->toIso8601String(),
                ],
            ], 201);
        }

        return back()->with('success', 'Thank you! Your growth audit request has been received.');
    }

    /**
     * Return list of agency services.
     */
    public function services(): JsonResponse
    {
        $servicesCategory = Category::where('slug', 'services')
            ->with(['subCategories' => function ($q) {
                $q->where('is_active', true)->orderBy('sort_order', 'asc');
            }])
            ->first();

        return response()->json([
            'success' => true,
            'data' => $servicesCategory,
        ]);
    }

    /**
     * Return list of portfolio case studies & articles.
     */
    public function portfolio(): JsonResponse
    {
        $items = PortfolioArticle::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->with('category:id,name,slug')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $items->count(),
            'data' => $items,
        ]);
    }
}
