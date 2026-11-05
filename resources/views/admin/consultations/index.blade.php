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

                    <!-- View Message Modal -->
                    <div class="modal fade" id="viewLeadModal{{ $lead->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Inquiry from {{ $lead->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <div class="text-muted small">Company / Organization:</div>
                                        <div class="fw-semibold">{{ $lead->company ?? 'Independent' }}</div>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <div class="text-muted small">Email:</div>
                                            <div><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted small">Phone:</div>
                                            <div>{{ $lead->phone ?? 'Not provided' }}</div>
                                        </div>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <div class="text-muted small">Service:</div>
                                            <div class="fw-medium">{{ $lead->service_interest }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted small">Budget:</div>
                                            <div class="fw-medium">{{ $lead->budget }}</div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="text-muted small mb-1">Project Requirements / Message:</div>
                                        <div class="p-3 bg-body-tertiary rounded border" style="white-space: pre-wrap;">{{ $lead->message }}</div>
                                    </div>
                                    <div class="small text-muted">
                                        <i class="bi bi-info-circle me-1"></i>IP: {{ $lead->ip_address ?? 'Unknown' }} &bull; Submitted: {{ $lead->created_at->toDayDateTimeString() }}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="mailto:{{ $lead->email }}?subject=Mahishika%20Digital%20Consultation%20Follow-up" class="btn btn-primary">
                                        <i class="bi bi-reply me-1"></i> Reply via Email
                                    </a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteLeadModal{{ $lead->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.consultations.delete', $lead) }}" method="POST" class="modal-content">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Consultation Lead</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete consultation lead from <strong>{{ $lead->name }}</strong> ({{ $lead->email }})?
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
@endsection

