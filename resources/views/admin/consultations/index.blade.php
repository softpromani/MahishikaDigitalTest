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
                    <th scope="col">Where to Start</th>
                    <th scope="col">Help Needed (Figma Topics)</th>
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
                            @php
                                $topics = is_array($lead->help_topics) ? $lead->help_topics : (is_string($lead->help_topics) ? json_decode($lead->help_topics, true) : null);
                            @endphp
                            @if(!empty($topics))
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($topics as $topic)
                                        @php
                                            $topicColor = match(strtolower($topic)) {
                                                'tech' => 'bg-info-subtle text-info border-info-subtle',
                                                'design' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                                                'video' => 'bg-danger-subtle text-danger border-danger-subtle',
                                                'marketing' => 'bg-success-subtle text-success border-success-subtle',
                                                default => 'bg-secondary-subtle text-secondary border-secondary-subtle'
                                            };
                                        @endphp
                                        <span class="badge {{ $topicColor }} border" style="font-size: 0.72rem;">{{ $topic }}</span>
                                    @endforeach
                                </div>
                            @elseif(!empty($lead->budget))
                                <div class="small fw-semibold">{{ $lead->budget }}</div>
                                <small class="text-muted">{{ $lead->timeline ?? 'Flexible' }}</small>
                            @else
                                <span class="text-muted small">&mdash;</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.consultations.status', $lead) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm consultation-status-select {{ $lead->status === 'new' ? 'border-danger text-danger fw-bold' : ($lead->status === 'completed' ? 'border-success text-success' : '') }}" data-endpoint="{{ route('admin.consultations.status', $lead) }}" title="Change lead status">
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
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <a href="mailto:{{ $lead->email }}" class="text-decoration-none fw-semibold"><i class="bi bi-envelope me-1"></i>{{ $lead->email }}</a>
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size: 0.75rem;" onclick="copyEmail('{{ $lead->email }}', this)" title="Copy email address">
                                    <i class="bi bi-clipboard"></i> Copy
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small fw-semibold">Phone:</div>
                            <div class="mt-1">{{ $lead->phone ?? 'Not provided' }}</div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <div class="text-muted small fw-semibold">Where to Start:</div>
                            <div class="mt-1"><span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">{{ $lead->service_interest }}</span></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small fw-semibold">Disciplines Needed:</div>
                            <div class="mt-1">
                                @php
                                    $topics = is_array($lead->help_topics) ? $lead->help_topics : (is_string($lead->help_topics) ? json_decode($lead->help_topics, true) : null);
                                @endphp
                                @if(!empty($topics))
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($topics as $topic)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">{{ $topic }}</span>
                                        @endforeach
                                    </div>
                                @elseif($lead->budget)
                                    <div class="fw-semibold text-success">{{ $lead->budget }}</div>
                                @else
                                    <span class="text-muted small">Not specified</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small fw-semibold mb-1">What's Not Working Today / Project Requirements:</div>
                        <div class="p-3 bg-light rounded-3 border text-body" style="white-space: pre-wrap; font-family: inherit; line-height: 1.6;">{{ $lead->message }}</div>
                    </div>
                    <div class="small text-muted border-top pt-2 mt-3">
                        <i class="bi bi-info-circle me-1"></i>IP: {{ $lead->ip_address ?? '127.0.0.1' }} &bull; Submitted: {{ $lead->created_at->toDayDateTimeString() }}
                    </div>

                    @php
                        $gmailSubject = rawurlencode("Mahishika Digital: Growth Audit Review Follow-up");
                        $gmailBody = rawurlencode("Hi {$lead->name},\n\nThank you for booking a growth audit with Mahishika Digital regarding {$lead->service_interest}.\n\nWe reviewed what is not working in your current setup and prepared preliminary audit observations.\n\nPlease let us know what dates and times work best for your team this week for a 20-minute review call.\n\nBest regards,\nMahishika Digital Team\nhttps://mahishika.digital");
                        $gmailUrl = "https://mail.google.com/mail/?view=cm&fs=1&to=" . rawurlencode($lead->email) . "&su={$gmailSubject}&body={$gmailBody}";
                        $outlookUrl = "https://outlook.live.com/mail/0/deeplink/compose?to=" . rawurlencode($lead->email) . "&subject={$gmailSubject}&body={$gmailBody}";
                    @endphp

                    <!-- In-App Quick Reply Section -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold mb-0 text-primary">
                                <i class="bi bi-reply-all-fill me-1"></i> Direct Response Options
                            </h6>
                            <div class="d-flex gap-2">
                                <a href="{{ $gmailUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger btn-sm" title="Compose in Gmail Web in a new tab">
                                    <i class="bi bi-google me-1"></i> Open in Gmail
                                </a>
                                <a href="{{ $outlookUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-sm" title="Compose in Outlook Web in a new tab">
                                    <i class="bi bi-microsoft me-1"></i> Outlook Web
                                </a>
                            </div>
                        </div>

                        <form action="{{ route('admin.consultations.reply', $lead) }}" method="POST" class="p-3 bg-light rounded-3 border">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label small fw-semibold text-secondary mb-1">Subject</label>
                                <input type="text" name="subject" class="form-control form-control-sm" value="Mahishika Digital Growth Audit: Follow-up on {{ $lead->service_interest }}" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-semibold text-secondary mb-1">Reply Message</label>
                                <textarea name="reply_message" rows="4" class="form-control form-control-sm" required>Hi {{ $lead->name }},

Thank you for reaching out to Mahishika Digital. We reviewed your growth audit request regarding {{ $lead->service_interest }}.

We would be pleased to schedule an introductory growth architecture discovery session. Please let us know your team's availability this week for a brief 20-minute call.

Best regards,
Mahishika Digital Solutions Team</textarea>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-2">
                                <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Sends reply and updates status to <strong>Contacted</strong>.</small>
                                <button type="submit" class="btn btn-success btn-sm px-3">
                                    <i class="bi bi-send-fill me-1"></i> Send Reply via System
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer border-top py-2 px-4 bg-body-tertiary d-flex justify-content-between">
                    <div class="d-flex gap-2 align-items-center">
                        <a href="{{ $gmailUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-danger btn-sm px-3">
                            <i class="bi bi-google me-1"></i> Reply via Gmail
                        </a>
                        <a href="mailto:{{ $lead->email }}?subject=Mahishika%20Digital%20Consultation%20Follow-up" class="btn btn-outline-secondary btn-sm" title="Open desktop default email program">
                            <i class="bi bi-envelope-at me-1"></i> Desktop App
                        </a>
                    </div>
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

<script>
    function copyEmail(email, btn) {
        if (!navigator.clipboard) {
            const tempInput = document.createElement('input');
            tempInput.value = email;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            showCopiedUI(btn);
            return;
        }

        navigator.clipboard.writeText(email).then(() => {
            showCopiedUI(btn);
        });
    }

    function showCopiedUI(btn) {
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check2-circle text-success"></i> Copied!';
        btn.classList.add('border-success', 'text-success');
        setTimeout(() => {
            btn.innerHTML = orig;
            btn.classList.remove('border-success', 'text-success');
        }, 2200);
    }
</script>
@endsection

