@extends('layouts.admin')

@section('title', 'Manage Categories')
@section('page_title', 'Top-Level Menu Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-secondary mb-0">These items populate the top navigation bar of Mahishika Digital.</p>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        <i class="bi bi-plus-lg me-1"></i> New Category
    </button>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 70px;">Order</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Badge</th>
                    <th scope="col">Sub-Categories</th>
                    <th scope="col">Featured Articles</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary-emphasis fw-bold">#{{ $category->sort_order }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi {{ $category->icon ?? 'bi-folder' }} fs-5 text-primary"></i>
                                <div>
                                    <div class="fw-semibold">{{ $category->name }}</div>
                                    <small class="text-muted d-block text-truncate" style="max-width: 250px;">{{ $category->description }}</small>
                                </div>
                            </div>
                        </td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td>
                            @if($category->badge)
                                <span class="badge bg-primary-subtle text-primary-emphasis border border-primary-subtle">{{ $category->badge }}</span>
                            @else
                                <span class="text-muted small">&mdash;</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.subcategories', ['category_id' => $category->id]) }}" class="badge bg-body-secondary text-body text-decoration-none">
                                {{ $category->sub_categories_count }} subcategories &rarr;
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $category->portfolio_articles_count }}</span>
                        </td>
                        <td>
                            <div class="form-check form-switch d-inline-flex align-items-center gap-2 mb-0">
                                <input class="form-check-input admin-status-toggle" 
                                       type="checkbox" 
                                       role="switch" 
                                       id="catStatus{{ $category->id }}"
                                       data-endpoint="{{ route('admin.categories.toggle-status', $category) }}"
                                       data-label-id="catStatusLabel{{ $category->id }}"
                                       title="Click to toggle status"
                                       {{ $category->is_active ? 'checked' : '' }}>
                                <label class="form-check-label mb-0 cursor-pointer" id="catStatusLabel{{ $category->id }}" for="catStatus{{ $category->id }}">
                                    @if($category->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Disabled</span>
                                    @endif
                                </label>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal{{ $category->id }}" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No categories created yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- All Category Edit & Delete Modals (Placed Outside Table for Valid DOM & Clean Backdrop) -->
@foreach($categories as $category)
    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCatLabel{{ $category->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="modal-content shadow-lg border">
                @csrf
                @method('PUT')
                <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title fw-bold" id="editCatLabel{{ $category->id }}">
                        <i class="bi bi-pencil-square text-primary me-2"></i>Edit Category: {{ $category->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" class="form-control" value="{{ $category->slug }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="2">{{ $category->description }}</textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Icon Class</label>
                            <input type="text" name="icon" class="form-control" value="{{ $category->icon }}" placeholder="bi-layers">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Badge</label>
                            <input type="text" name="badge" class="form-control" value="{{ $category->badge }}" placeholder="e.g. Popular">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ $category->sort_order }}" required>
                        </div>
                        <div class="col-6 d-flex align-items-center pt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="editActive{{ $category->id }}" value="1" {{ $category->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold small" for="editActive{{ $category->id }}">Active in Menu</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top py-2 px-4 bg-body-tertiary">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        <i class="bi bi-check-lg me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.categories.delete', $category) }}" method="POST" class="modal-content shadow-lg border">
                @csrf
                @method('DELETE')
                <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title fw-bold text-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    Are you sure you want to delete category <strong>{{ $category->name }}</strong>?
                    <div class="alert alert-warning mt-3 mb-0 small d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle me-2 fs-5"></i>
                        <div>
                            This will also delete <strong>{{ $category->sub_categories_count }} subcategories</strong> nested under it!
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top py-2 px-4 bg-body-tertiary">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete Category</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCatLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="modal-content shadow-lg border">
            @csrf
            <div class="modal-header border-bottom py-3">
                <h5 class="modal-title fw-bold" id="createCatLabel">
                    <i class="bi bi-plus-circle text-primary me-2"></i>Create New Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Services, Solutions" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Slug (Optional)</label>
                    <input type="text" name="slug" class="form-control" placeholder="Auto-generated if blank">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Brief summary for menu intro"></textarea>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Icon Class</label>
                        <input type="text" name="icon" class="form-control" placeholder="bi-layers">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Badge</label>
                        <input type="text" name="badge" class="form-control" placeholder="e.g. New">
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <div class="col-6 d-flex align-items-center pt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="createActive" value="1" checked>
                            <label class="form-check-label fw-semibold small" for="createActive">Active in Menu</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top py-2 px-4 bg-body-tertiary">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm px-3">Create Category</button>
            </div>
        </form>
    </div>
</div>
@endsection
