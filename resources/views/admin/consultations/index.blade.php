@extends('layouts.admin')

@section('title', 'Consultation Inquiries')
@section('page_title', 'Client Consultation Requests')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-secondary mb-0">Incoming project inquiries submitted via the "Book a Consultation" mega menu CTA & form.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col">Client Name</th>
                    <th scope="col">Company</th>
                    <th scope="col">Service Interest</th>
                    <th scope="col">Budget & Timeline</th>
                    <th scope="col">Status</th>
                    <th scope="col">Received</th>
                    <th scope="col" class="text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultations as $lead)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $lead->name }}</div>
                            <small class="text-muted"><i class="bi bi-envelope me-1"></i>{{ $lead->email }}</small>
                            @if($lead->phone)
                                <small class="text-muted d-block"><i class="bi bi-telephone me-1"></i>{{ $lead->phone }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="fw-medium">{{ $lead->company ?? 'Independent' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                {{ $lead->service_interest ?? 'General Consultation' }}
                            </span>
                        </td>
                        <td>
                            <div class="small fw-semibold">{{ $lead->budget ?? 'Not specified' }}</div>
                            <small class="text-muted">{{ $lead->timeline ?? 'Flexible' }}</small>
                        </td>
                        <td>
                            <form action="{{ route('admin.consultations.status', $lead) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm {{ $lead->status === 'new' ? 'border-danger text-danger fw-bold' : ($lead->status === 'completed' ? 'border-success text-success' : '') }}" onchange="this.form.submit()">
                                    <option value="new" {{ $lead->status === 'new' ? 'selected' : '' }}>🔴 New</option>
                                    <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>🟡 Contacted</option>
                                    <option value="scheduled" {{ $lead->status === 'scheduled' ? 'selected' : '' }}>🔵 Scheduled</option>
                                    <option value="completed" {{ $lead->status === 'completed' ? 'selected' : '' }}>🟢 Completed</option>
                                    <option value="archived" {{ $lead->status === 'archived' ? 'selected' : '' }}>⚪ Archived</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <time class="small text-muted">{{ $lead->created_at->format('M d, Y H:i') }}</time>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#viewLeadModal{{ $lead->id }}" title="View Full Message">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteLeadModal{{ $lead->id }}" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No consultations received yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($consultations->hasPages())
        <div class="card-footer bg-transparent py-3">
            {{ $consultations->links() }}
        </div>
    @endif
</div>

<!-- Consultation Modals (Rendered Outside Table for Clean Backdrop & Valid DOM) -->
@foreach($consultations as $lead)
    <!-- View Message Modal -->
    <div class="modal fade" id="viewLeadModal{{ $lead->id }}" tabindex="-1" aria-labelledby="viewLeadLabel{{ $lead->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border">
                <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title fw-bold" id="viewLeadLabel{{ $lead->id }}">
                        <i class="bi bi-chat-quote-fill text-primary me-2"></i>Inquiry from {{ $lead->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <div class="text-muted small fw-semibold">Company / Organization:</div>
                        <div class="fw-bold fs-6">{{ $lead->company ?? 'Independent / Not specified' }}</div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <div class="text-muted small fw-semibold">Email:</div>
                            <div><a href="mailto:{{ $lead->email }}" class="text-decoration-none fw-medium"><i class="bi bi-envelope me-1"></i>{{ $lead->email }}</a></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small fw-semibold">Phone:</div>
                            <div>{{ $lead->phone ?? 'Not provided' }}</div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <div class="text-muted small fw-semibold">Interested Service:</div>
                            <div><span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">{{ $lead->service_interest }}</span></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small fw-semibold">Estimated Budget:</div>
                            <div class="fw-semibold text-success">{{ $lead->budget }}</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small fw-semibold mb-1">Project Requirements / Message:</div>
                        <div class="p-3 bg-light rounded-3 border text-body" style="white-space: pre-wrap; font-family: inherit; line-height: 1.6;">{{ $lead->message }}</div>
                    </div>
                    <div class="small text-muted border-top pt-2 mt-3">
                        <i class="bi bi-info-circle me-1"></i>IP: {{ $lead->ip_address ?? '127.0.0.1' }} &bull; Submitted: {{ $lead->created_at->toDayDateTimeString() }}
                    </div>
                </div>
                <div class="modal-footer border-top py-2 px-4 bg-body-tertiary">
                    <a href="mailto:{{ $lead->email }}?subject=Mahishika%20Digital%20Consultation%20Follow-up" class="btn btn-primary btn-sm px-3">
                        <i class="bi bi-reply me-1"></i> Reply via Email
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteLeadModal{{ $lead->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.consultations.delete', $lead) }}" method="POST" class="modal-content shadow-lg border">
                @csrf
                @method('DELETE')
                <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title fw-bold text-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    Are you sure you want to delete the consultation lead from <strong>{{ $lead->name }}</strong> (<code>{{ $lead->email }}</code>)?
                </div>
                <div class="modal-footer border-top py-2 px-4 bg-body-tertiary">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm px-3">Delete Lead</button>
                </div>
            </form>
        </div>
    </div>
@endforeach
@endsection

