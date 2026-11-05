<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Consultation;
use App\Models\PortfolioArticle;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Admin dashboard summary.
     */
    public function index(): View
    {
        $categoryCount = Category::count();
        $subCategoryCount = SubCategory::count();
        $portfolioCount = PortfolioArticle::count();
        $consultationCount = Consultation::count();
        $newConsultationsCount = Consultation::where('status', 'new')->count();

        $recentConsultations = Consultation::latest()->limit(5)->get();
        $categories = Category::withCount(['subCategories', 'portfolioArticles'])->orderBy('sort_order', 'asc')->get();

        return view('admin.dashboard', compact(
            'categoryCount',
            'subCategoryCount',
            'portfolioCount',
            'consultationCount',
            'newConsultationsCount',
            'recentConsultations',
            'categories'
        ));
    }

    /**
     * Categories management list.
     */
    public function categories(): View
    {
        $categories = Category::withCount(['subCategories', 'portfolioArticles'])
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a newly created category.
     */
    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:categories,slug',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'badge' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? (Category::max('sort_order') + 1);

        Category::create($validated);

        return redirect()->route('admin.categories')->with('success', "Category '{$validated['name']}' created successfully.");
    }

    /**
     * Update an existing category.
     */
    public function updateCategory(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'badge' => 'nullable|string|max:50',
            'sort_order' => 'required|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        return redirect()->route('admin.categories')->with('success', "Category '{$category->name}' updated successfully.");
    }

    /**
     * Delete a category.
     */
    public function deleteCategory(Category $category): RedirectResponse
    {
        $name = $category->name;
        $category->delete();

        return redirect()->route('admin.categories')->with('success', "Category '{$name}' deleted successfully.");
    }

    /**
     * Toggle active status of a category.
     */
    public function toggleCategoryStatus(Request $request, Category $category): JsonResponse|RedirectResponse
    {
        $category->is_active = !$category->is_active;
        $category->save();

        $state = $category->is_active ? 'Active' : 'Disabled';
        $message = "Category '{$category->name}' status updated to {$state}.";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => (bool)$category->is_active,
                'state_text' => $state,
                'message' => $message,
            ]);
        }

        return redirect()->route('admin.categories')->with('success', $message);
    }

    /**
     * Subcategories management list.
     */
    public function subcategories(Request $request): View
    {
        $categoryId = $request->query('category_id');

        $query = SubCategory::with('category')->orderBy('sort_order', 'asc');
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        $subcategories = $query->paginate(15);
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.subcategories.index', compact('subcategories', 'categories', 'categoryId'));
    }

    /**
     * Store a newly created subcategory.
     */
    public function storeSubCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:150',
            'slug' => 'nullable|string|max:150',
            'description' => 'nullable|string|max:500',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'badge' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? (SubCategory::where('category_id', $validated['category_id'])->max('sort_order') + 1);

        SubCategory::create($validated);

        return redirect()->route('admin.subcategories', ['category_id' => $validated['category_id']])
            ->with('success', "Subcategory '{$validated['title']}' created successfully.");
    }

    /**
     * Update an existing subcategory.
     */
    public function updateSubCategory(Request $request, SubCategory $subCategory): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:150',
            'slug' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'badge' => 'nullable|string|max:50',
            'sort_order' => 'required|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $subCategory->update($validated);

        return redirect()->route('admin.subcategories', ['category_id' => $subCategory->category_id])
            ->with('success', "Subcategory '{$subCategory->title}' updated successfully.");
    }

    /**
     * Delete a subcategory.
     */
    public function deleteSubCategory(SubCategory $subCategory): RedirectResponse
    {
        $title = $subCategory->title;
        $catId = $subCategory->category_id;
        $subCategory->delete();

        return redirect()->route('admin.subcategories', ['category_id' => $catId])
            ->with('success', "Subcategory '{$title}' deleted successfully.");
    }

    /**
     * Toggle active status of a subcategory.
     */
    public function toggleSubCategoryStatus(Request $request, SubCategory $subCategory): JsonResponse|RedirectResponse
    {
        $subCategory->is_active = !$subCategory->is_active;
        $subCategory->save();

        $state = $subCategory->is_active ? 'Active' : 'Disabled';
        $message = "Subcategory '{$subCategory->title}' status updated to {$state}.";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => (bool)$subCategory->is_active,
                'state_text' => $state,
                'message' => $message,
            ]);
        }

        return redirect()->route('admin.subcategories', ['category_id' => $subCategory->category_id])
            ->with('success', $message);
    }

    /**
     * Portfolio / Articles management list.
     */
    public function portfolio(Request $request): View
    {
        $type = $request->query('type');
        $query = PortfolioArticle::with('category')->orderBy('sort_order', 'asc');
        if ($type) {
            $query->where('type', $type);
        }
        $articles = $query->paginate(12);
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.portfolio.index', compact('articles', 'categories', 'type'));
    }

    /**
     * Store portfolio / article.
     */
    public function storePortfolio(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:portfolio_articles,slug',
            'type' => 'required|in:case_study,article,highlight',
            'client_name' => 'nullable|string|max:100',
            'excerpt' => 'required|string|max:1000',
            'tag' => 'nullable|string|max:50',
            'metric' => 'nullable|string|max:50',
            'metric_label' => 'nullable|string|max:50',
            'image_url' => 'nullable|url|max:500',
            'link_url' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? (PortfolioArticle::max('sort_order') + 1);

        PortfolioArticle::create($validated);

        return redirect()->route('admin.portfolio')->with('success', "Item '{$validated['title']}' created successfully.");
    }

    /**
     * Update portfolio / article.
     */
    public function updatePortfolio(Request $request, PortfolioArticle $portfolioArticle): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:portfolio_articles,slug,' . $portfolioArticle->id,
            'type' => 'required|in:case_study,article,highlight',
            'client_name' => 'nullable|string|max:100',
            'excerpt' => 'required|string|max:1000',
            'tag' => 'nullable|string|max:50',
            'metric' => 'nullable|string|max:50',
            'metric_label' => 'nullable|string|max:50',
            'image_url' => 'nullable|url|max:500',
            'link_url' => 'required|string|max:255',
            'sort_order' => 'required|integer',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $portfolioArticle->update($validated);

        return redirect()->route('admin.portfolio')->with('success', "Item '{$portfolioArticle->title}' updated successfully.");
    }

    /**
     * Delete portfolio / article.
     */
    public function deletePortfolio(PortfolioArticle $portfolioArticle): RedirectResponse
    {
        $title = $portfolioArticle->title;
        $portfolioArticle->delete();

        return redirect()->route('admin.portfolio')->with('success', "Item '{$title}' deleted successfully.");
    }

    /**
     * Toggle active status of a portfolio article.
     */
    public function togglePortfolioStatus(Request $request, PortfolioArticle $portfolioArticle): JsonResponse|RedirectResponse
    {
        $portfolioArticle->is_active = !$portfolioArticle->is_active;
        $portfolioArticle->save();

        $state = $portfolioArticle->is_active ? 'Active' : 'Disabled';
        $message = "Portfolio item '{$portfolioArticle->title}' status updated to {$state}.";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => (bool)$portfolioArticle->is_active,
                'state_text' => $state,
                'message' => $message,
            ]);
        }

        return redirect()->route('admin.portfolio')->with('success', $message);
    }

    /**
     * Toggle featured status of a portfolio article.
     */
    public function togglePortfolioFeatured(Request $request, PortfolioArticle $portfolioArticle): JsonResponse|RedirectResponse
    {
        $portfolioArticle->is_featured = !$portfolioArticle->is_featured;
        $portfolioArticle->save();

        $state = $portfolioArticle->is_featured ? 'Featured' : 'Standard';
        $message = "Portfolio item '{$portfolioArticle->title}' is now {$state}.";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_featured' => (bool)$portfolioArticle->is_featured,
                'state_text' => $state,
                'message' => $message,
            ]);
        }

        return redirect()->route('admin.portfolio')->with('success', $message);
    }

    /**
     * Consultations leads list.
     */
    public function consultations(): View
    {
        $consultations = Consultation::latest()->paginate(15);

        return view('admin.consultations.index', compact('consultations'));
    }

    /**
     * Update consultation status.
     */
    public function updateConsultationStatus(Request $request, Consultation $consultation): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,scheduled,completed,archived',
        ]);

        $consultation->update($validated);

        $message = "Status updated to '" . ucfirst($validated['status']) . "'.";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $validated['status'],
                'message' => $message,
            ]);
        }

        return redirect()->route('admin.consultations')->with('success', $message);
    }

    /**
     * Send in-app reply to consultation lead and update status to contacted.
     */
    public function replyConsultation(Request $request, Consultation $consultation): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:200',
            'reply_message' => 'required|string|max:5000',
        ]);

        // Automatically update lead status to contacted
        $consultation->update(['status' => 'contacted']);

        \Illuminate\Support\Facades\Log::info("Consultation reply dispatched to {$consultation->email}", [
            'consultation_id' => $consultation->id,
            'subject' => $validated['subject'],
            'message' => $validated['reply_message'],
        ]);

        return redirect()->route('admin.consultations')->with('success', "Reply sent to {$consultation->email}! Lead marked as 'Contacted'.");
    }

    /**
     * Delete consultation lead.
     */
    public function deleteConsultation(Consultation $consultation): RedirectResponse
    {
        $name = $consultation->name;
        $consultation->delete();

        return redirect()->route('admin.consultations')->with('success', "Consultation lead from '{$name}' deleted.");
    }
}
