@extends('layouts.admin')

@section('title', 'Manage Portfolio & Articles')
@section('page_title', 'Portfolio & Case Studies')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-2">
        <label class="form-label mb-0 fw-semibold text-secondary">Filter by Type:</label>
        <select class="form-select form-select-sm" style="width: 180px;" onchange="window.location.href=this.value">
            <option value="{{ route('admin.portfolio') }}">All Types</option>
            <option value="{{ route('admin.portfolio', ['type' => 'case_study']) }}" {{ $type === 'case_study' ? 'selected' : '' }}>Case Studies</option>
            <option value="{{ route('admin.portfolio', ['type' => 'article']) }}" {{ $type === 'article' ? 'selected' : '' }}>Articles</option>
            <option value="{{ route('admin.portfolio', ['type' => 'highlight']) }}" {{ $type === 'highlight' ? 'selected' : '' }}>Highlights</option>
        </select>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPortfolioModal">
        <i class="bi bi-plus-lg me-1"></i> New Item
    </button>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 70px;">Order</th>
                    <th scope="col">Thumbnail</th>
                    <th scope="col">Title & Client</th>
                    <th scope="col">Menu Category</th>
                    <th scope="col">Key Metric</th>
                    <th scope="col">Type</th>
                    <th scope="col">Featured</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $item)
                    <tr>
                        <td><span class="badge bg-secondary-subtle text-secondary-emphasis">#{{ $item->sort_order }}</span></td>
                        <td>
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="rounded object-fit-cover" width="60" height="40" loading="lazy" onerror="this.src='/assets/images/tech-case.jpg'">
                            @else
                                <div class="bg-secondary-subtle rounded d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 40px;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $item->title }}</div>
                            <small class="text-muted">
                                @if($item->client_name)
                                    <i class="bi bi-building me-1"></i>{{ $item->client_name }} &bull;
                                @endif
                                <span class="badge bg-light text-dark border">{{ $item->tag ?? 'General' }}</span>
                            </small>
                        </td>
                        <td>
                            @if($item->category)
                                @php
                                    $dot = match($item->category->slug) {
                                        'design' => '#f59e0b',
                                        'video' => '#ef4444',
                                        'tech' => '#0ea5e9',
                                        'marketing' => '#10b981',
                                        default => '#6366f1'
                                    };
                                @endphp
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                    <span class="d-inline-block rounded-circle me-1" style="width: 7px; height: 7px; background-color: {{ $dot }};"></span>
                                    {{ $item->category->name }}
                                </span>
                            @else
                                <span class="text-muted small">Global</span>
                            @endif
                        </td>
                        <td>
                            @if($item->metric)
                                <span class="badge bg-success-subtle text-success fw-bold">{{ $item->metric }}</span>
                                <small class="text-muted d-block" style="font-size: 0.72rem;">{{ $item->metric_label }}</small>
                            @else
                                <span class="text-muted small">&mdash;</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $item->type === 'case_study' ? 'bg-primary' : ($item->type === 'article' ? 'bg-info' : 'bg-secondary') }}">
                                {{ str_replace('_', ' ', ucfirst($item->type)) }}
                            </span>
                        </td>
                        <td>
                            <div class="form-check form-switch d-inline-flex align-items-center gap-2 mb-0">
                                <input class="form-check-input admin-status-toggle toggle-featured" 
                                       type="checkbox" 
                                       role="switch" 
                                       id="portFeat{{ $item->id }}"
                                       data-endpoint="{{ route('admin.portfolio.toggle-featured', $item) }}"
                                       data-label-id="portFeatLabel{{ $item->id }}"
                                       data-item-name="{{ $item->title }}"
                                       data-item-type="Portfolio Item"
                                       data-toggle-type="featured"
                                       title="Click to toggle featured status"
                                       {{ $item->is_featured ? 'checked' : '' }}>
                                <label class="form-check-label mb-0 cursor-pointer" id="portFeatLabel{{ $item->id }}" for="portFeat{{ $item->id }}">
                                    @if($item->is_featured)
                                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>Featured</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Standard</span>
                                    @endif
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="form-check form-switch d-inline-flex align-items-center gap-2 mb-0">
                                <input class="form-check-input admin-status-toggle" 
                                       type="checkbox" 
                                       role="switch" 
                                       id="portStatus{{ $item->id }}"
                                       data-endpoint="{{ route('admin.portfolio.toggle-status', $item) }}"
                                       data-label-id="portStatusLabel{{ $item->id }}"
                                       data-item-name="{{ $item->title }}"
                                       data-item-type="Portfolio Item"
                                       data-toggle-type="status"
                                       title="Click to toggle active status"
                                       {{ $item->is_active ? 'checked' : '' }}>
                                <label class="form-check-label mb-0 cursor-pointer" id="portStatusLabel{{ $item->id }}" for="portStatus{{ $item->id }}">
                                    @if($item->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Disabled</span>
                                    @endif
                                </label>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editPortfolioModal{{ $item->id }}" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePortfolioModal{{ $item->id }}" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">No portfolio items found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($articles->hasPages())
        <div class="card-footer bg-transparent py-3">
            {{ $articles->withQueryString()->links() }}
        </div>
    @endif
</div>

<!-- All Portfolio Edit & Delete Modals (Placed Outside Table for Valid DOM) -->
@foreach($articles as $item)
    <!-- Edit Modal -->
    <div class="modal fade" id="editPortfolioModal{{ $item->id }}" tabindex="-1" aria-labelledby="editPortLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form action="{{ route('admin.portfolio.update', $item) }}" method="POST" class="modal-content shadow-lg border">
                @csrf
                @method('PUT')
                <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title fw-bold" id="editPortLabel{{ $item->id }}">
                        <i class="bi bi-pencil-square text-primary me-2"></i>Edit: {{ $item->title }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $item->title }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Type</label>
                            <select name="type" class="form-select" required>
                                <option value="case_study" {{ $item->type === 'case_study' ? 'selected' : '' }}>Case Study</option>
                                <option value="article" {{ $item->type === 'article' ? 'selected' : '' }}>Article / Insight</option>
                                <option value="highlight" {{ $item->type === 'highlight' ? 'selected' : '' }}>Highlight</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{ $item->slug }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Menu Category (Associates in Mega Menu)</label>
                            <select name="category_id" class="form-select">
                                <option value="">None (Global)</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Client Name</label>
                            <input type="text" name="client_name" class="form-control" value="{{ $item->client_name }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tag</label>
                            <input type="text" name="tag" class="form-control" value="{{ $item->tag }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Excerpt</label>
                        <textarea name="excerpt" class="form-control" rows="2" required>{{ $item->excerpt }}</textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Metric Value</label>
                            <input type="text" name="metric" class="form-control" value="{{ $item->metric }}" placeholder="e.g. +312%">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Metric Label</label>
                            <input type="text" name="metric_label" class="form-control" value="{{ $item->metric_label }}" placeholder="e.g. Conversion Lift">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Image URL</label>
                            <input type="url" name="image_url" class="form-control" value="{{ $item->image_url }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Link URL</label>
                            <input type="text" name="link_url" class="form-control" value="{{ $item->link_url }}" required>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ $item->sort_order }}" required>
                        </div>
                        <div class="col-md-4 d-flex align-items-center pt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="feat{{ $item->id }}" value="1" {{ $item->is_featured ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold small" for="feat{{ $item->id }}">Featured in Mega Menu</label>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center pt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="act{{ $item->id }}" value="1" {{ $item->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold small" for="act{{ $item->id }}">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top py-2 px-4 bg-body-tertiary">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm px-3">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deletePortfolioModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.portfolio.delete', $item) }}" method="POST" class="modal-content shadow-lg border">
                @csrf
                @method('DELETE')
                <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title fw-bold text-danger">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    Are you sure you want to delete <strong>{{ $item->title }}</strong>?
                </div>
                <div class="modal-footer border-top py-2 px-4 bg-body-tertiary">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

<!-- Create Portfolio Modal -->
<div class="modal fade" id="createPortfolioModal" tabindex="-1" aria-labelledby="createPortLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('admin.portfolio.store') }}" method="POST" class="modal-content shadow-lg border">
            @csrf
            <div class="modal-header border-bottom py-3">
                <h5 class="modal-title fw-bold" id="createPortLabel">
                    <i class="bi bi-plus-circle text-primary me-2"></i>Create Portfolio or Article
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Scaling FinTech: 5M+ Daily Transactions" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="case_study">Case Study</option>
                            <option value="article">Article / Insight</option>
                            <option value="highlight">Highlight</option>
                        </select>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Slug (Optional)</label>
                        <input type="text" name="slug" class="form-control" placeholder="Auto-generated if blank">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Menu Category (Associates in Mega Menu)</label>
                        <select name="category_id" class="form-select">
                            <option value="">None (Global)</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Client Name</label>
                        <input type="text" name="client_name" class="form-control" placeholder="e.g. Apex Bank">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tag</label>
                        <input type="text" name="tag" class="form-control" placeholder="e.g. Cloud Scale">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Excerpt <span class="text-danger">*</span></label>
                    <textarea name="excerpt" class="form-control" rows="2" placeholder="One or two sentences describing technical outcome" required></textarea>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Metric Value</label>
                        <input type="text" name="metric" class="form-control" placeholder="e.g. 99.999% or +312%">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Metric Label</label>
                        <input type="text" name="metric_label" class="form-control" placeholder="e.g. Uptime SLA or Conversion">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Image URL</label>
                        <input type="url" name="image_url" class="form-control" placeholder="https://images.unsplash.com/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Link URL <span class="text-danger">*</span></label>
                        <input type="text" name="link_url" class="form-control" value="#" required>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <div class="col-md-4 d-flex align-items-center pt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="createFeat" value="1" checked>
                            <label class="form-check-label fw-semibold small" for="createFeat">Featured in Mega Menu</label>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center pt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="createAct" value="1" checked>
                            <label class="form-check-label fw-semibold small" for="createAct">Active</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top py-2 px-4 bg-body-tertiary">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm px-3">Create Item</button>
            </div>
        </form>
    </div>
</div>
@endsection
