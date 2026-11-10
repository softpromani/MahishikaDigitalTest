@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Agency Overview & Menu Management')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stat Cards -->
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary small fw-medium text-uppercase">Top-Level Categories</span>
                    <h2 class="h3 fw-bold mt-1 mb-0">{{ $categoryCount }}</h2>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                    <i class="bi bi-grid-fill fs-4"></i>
                </div>
            </div>
            <div class="mt-3 small text-muted">
                Controls top navigation tabs
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary small fw-medium text-uppercase">Sub-Categories</span>
                    <h2 class="h3 fw-bold mt-1 mb-0">{{ $subCategoryCount }}</h2>
                </div>
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                    <i class="bi bi-list-nested fs-4"></i>
                </div>
            </div>
            <div class="mt-3 small text-muted">
                Mega menu nested columns & links
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary small fw-medium text-uppercase">Portfolio / Articles</span>
                    <h2 class="h3 fw-bold mt-1 mb-0">{{ $portfolioCount }}</h2>
                </div>
                <div class="bg-info bg-opacity-10 text-info p-3 rounded-3">
                    <i class="bi bi-briefcase-fill fs-4"></i>
                </div>
            </div>
            <div class="mt-3 small text-muted">
                Featured cards in mega menu & page
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary small fw-medium text-uppercase">Consultation Leads</span>
                    <h2 class="h3 fw-bold mt-1 mb-0">{{ $consultationCount }}</h2>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                    <i class="bi bi-chat-left-dots-fill fs-4"></i>
                </div>
            </div>
            <div class="mt-3 small text-muted">
                <span class="badge bg-danger">{{ $newConsultationsCount }} new</span> awaiting review
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Active Mega Menu Hierarchy Preview -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom py-3 d-flex align-items-center justify-content-between">
                <h2 class="h6 mb-0 fw-bold">
                    <i class="bi bi-diagram-3 me-2 text-primary"></i>Live Mega Menu Structure
                </h2>
                <a href="{{ route('admin.categories') }}" class="btn btn-sm btn-outline-primary">Manage Categories</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($categories as $category)
                        @php
                            $isVertical = in_array($category->slug, ['tech', 'design', 'video', 'marketing']);
                            $dotColor = match($category->slug) {
                                'design' => '#f59e0b',
                                'video' => '#ef4444',
                                'tech' => '#0ea5e9',
                                'marketing' => '#10b981',
                                default => '#6366f1'
                            };
                        @endphp
                        <div class="list-group-item p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-2 text-white p-1" style="width: 28px; height: 28px; background-color: {{ $dotColor }};">
                                        <i class="bi {{ $category->icon ?? 'bi-folder' }} fs-6"></i>
                                    </span>
                                    <strong class="fs-6">{{ $category->name }}</strong>
                                    @if($isVertical)
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle" style="font-size: 0.7rem;">Mega Menu Vertical</span>
                                    @endif
                                    @if($category->badge)
                                        <span class="badge bg-secondary-subtle text-secondary-emphasis" style="font-size: 0.7rem;">{{ $category->badge }}</span>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-light text-dark border">{{ $category->sub_categories_count }} Subcategories</span>
                                    <span class="badge bg-light text-dark border">{{ $category->portfolio_articles_count }} Featured</span>
                                    <a href="{{ route('admin.subcategories', ['category_id' => $category->id]) }}" class="btn btn-sm btn-link p-0 text-decoration-none">Edit Items &rarr;</a>
                                </div>
                            </div>
                            <p class="text-secondary small mb-2">{{ $category->description }}</p>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($category->subCategories as $sub)
                                    <span class="badge bg-body-secondary text-body fw-normal border">
                                        <i class="bi {{ $sub->icon ?? 'bi-link' }} me-1 opacity-50"></i>{{ $sub->title }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">No categories configured yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Consultation Inquiries -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-bottom py-3 d-flex align-items-center justify-content-between">
                <h2 class="h6 mb-0 fw-bold">
                    <i class="bi bi-clock-history me-2 text-warning"></i>Recent Consultation Inquiries
                </h2>
                <a href="{{ route('admin.consultations') }}" class="btn btn-sm btn-outline-secondary">View All Leads</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentConsultations as $lead)
                        <div class="list-group-item p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h3 class="h6 fw-semibold mb-0">{{ $lead->name }}</h3>
                                <span class="badge {{ $lead->status === 'new' ? 'bg-danger' : 'bg-success' }}">
                                    {{ ucfirst($lead->status) }}
                                </span>
                            </div>
                            <div class="small text-muted mb-2">
                                <i class="bi bi-building me-1"></i>{{ $lead->company ?? 'Independent / Stealth' }} &bull;
                                <i class="bi bi-envelope me-1"></i>{{ $lead->email }}
                            </div>
                            <div class="small bg-body-tertiary p-2 rounded mb-2 text-truncate">
                                "{{ $lead->message }}"
                            </div>
                            <div class="d-flex justify-content-between align-items-center small text-secondary">
                                <span><i class="bi bi-tag me-1"></i>{{ $lead->service_interest ?? 'General' }}</span>
                                <time>{{ $lead->created_at->diffForHumans() }}</time>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">No consultations received yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

