@extends('layouts.admin')

@section('title', 'Manage Sub-Categories')
@section('page_title', 'Mega Menu Sub-Categories')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-2">
        <label class="form-label mb-0 fw-semibold text-secondary">Filter by Category:</label>
        <select class="form-select form-select-sm" style="width: 220px;" onchange="window.location.href=this.value">
            <option value="{{ route('admin.subcategories') }}">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ route('admin.subcategories', ['category_id' => $cat->id]) }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSubCategoryModal">
        <i class="bi bi-plus-lg me-1"></i> New Sub-Category
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 70px;">Order</th>
                    <th scope="col">Parent Category</th>
                    <th scope="col">Sub-Category Title</th>
                    <th scope="col">Destination URL</th>
                    <th scope="col">Badge</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subcategories as $item)
                    <tr>
                        <td><span class="badge bg-secondary-subtle text-secondary-emphasis">#{{ $item->sort_order }}</span></td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                <i class="bi {{ $item->category->icon ?? 'bi-folder' }} me-1"></i>{{ $item->category->name }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi {{ $item->icon ?? 'bi-link' }} fs-5 text-secondary"></i>
                                <div>
                                    <div class="fw-semibold">{{ $item->title }}</div>
                                    <small class="text-muted d-block text-truncate" style="max-width: 320px;">{{ $item->description }}</small>
                                </div>
                            </div>
                        </td>
                        <td><code>{{ $item->url }}</code></td>
                        <td>
                            @if($item->badge)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">{{ $item->badge }}</span>
                            @else
                                <span class="text-muted small">&mdash;</span>
                            @endif
                        </td>
                        <td>
                            @if($item->is_active)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                            @else
                                <span class="badge bg-secondary">Disabled</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editSubModal{{ $item->id }}" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteSubModal{{ $item->id }}" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editSubModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.subcategories.update', $item) }}" method="POST" class="modal-content">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Sub-Category: {{ $item->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Parent Category</label>
                                        <select name="category_id" class="form-select" required>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Title</label>
                                        <input type="text" name="title" class="form-control" value="{{ $item->title }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Slug</label>
                                        <input type="text" name="slug" class="form-control" value="{{ $item->slug }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Description</label>
                                        <textarea name="description" class="form-control" rows="2">{{ $item->description }}</textarea>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">URL Destination</label>
                                            <input type="text" name="url" class="form-control" value="{{ $item->url }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Icon Class</label>
                                            <input type="text" name="icon" class="form-control" value="{{ $item->icon }}">
                                        </div>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Badge</label>
                                            <input type="text" name="badge" class="form-control" value="{{ $item->badge }}">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-semibold">Sort Order</label>
                                            <input type="number" name="sort_order" class="form-control" value="{{ $item->sort_order }}" required>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="subActive{{ $item->id }}" value="1" {{ $item->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="subActive{{ $item->id }}">Active in Mega Menu</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteSubModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.subcategories.delete', $item) }}" method="POST" class="modal-content">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete <strong>{{ $item->title }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No subcategories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($subcategories->hasPages())
        <div class="card-footer bg-transparent py-3">
            {{ $subcategories->withQueryString()->links() }}
        </div>
    @endif
</div>

<!-- Create SubCategory Modal -->
<div class="modal fade" id="createSubCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.subcategories.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Create New Sub-Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Parent Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Cloud Architecture & DevOps" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Slug (Optional)</label>
                    <input type="text" name="slug" class="form-control" placeholder="Auto-generated if empty">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Brief feature summary shown in mega menu"></textarea>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold">URL Destination <span class="text-danger">*</span></label>
                        <input type="text" name="url" class="form-control" value="#" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Icon Class</label>
                        <input type="text" name="icon" class="form-control" placeholder="bi-cloud-check">
                    </div>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Badge</label>
                        <input type="text" name="badge" class="form-control" placeholder="e.g. Popular, New">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="createSubActive" value="1" checked>
                    <label class="form-check-label" for="createSubActive">Active in Mega Menu</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Sub-Category</button>
            </div>
        </form>
    </div>
</div>
@endsection

