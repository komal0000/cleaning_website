@extends('admin.layouts.app')

@section('title', 'Message Details')
@section('page-title', 'Contact Messages')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Message from ' . $contactMessage->name,
        'description' => 'Submitted ' . $contactMessage->created_at->diffForHumans() . '.',
        'actions' => '<a href="' . route('admin.contact-messages.index') . '" class="btn btn-light"><i data-lucide="arrow-left"></i> Back to Messages</a>',
    ])

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Message Details</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9">{{ $contactMessage->name }}</dd>

                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9">
                            <a href="mailto:{{ $contactMessage->email }}" class="text-decoration-none">
                                {{ $contactMessage->email }}
                            </a>
                        </dd>

                        <dt class="col-sm-3">Phone</dt>
                        <dd class="col-sm-9">
                            @if($contactMessage->phone)
                                <a href="tel:{{ $contactMessage->phone }}" class="text-decoration-none">
                                    {{ $contactMessage->phone }}
                                </a>
                            @else
                                <span class="text-muted">Not provided</span>
                            @endif
                        </dd>

                        <dt class="col-sm-3">Service</dt>
                        <dd class="col-sm-9">
                            <span class="badge bg-info">{{ $contactMessage->service }}</span>
                        </dd>

                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9">
                            <span class="badge {{ $contactMessage->status_badge }} status-badge"
                                  data-id="{{ $contactMessage->id }}"
                                  data-status="{{ $contactMessage->status }}"
                                  onclick="openStatusModal({{ $contactMessage->id }}, '{{ $contactMessage->status }}')"
                                  style="cursor: pointer;">
                                {{ $contactMessage->status_label }}
                            </span>
                        </dd>

                        <dt class="col-sm-3">Date</dt>
                        <dd class="col-sm-9">{{ $contactMessage->created_at->format('F d, Y \a\t h:i A') }}</dd>

                        @if($contactMessage->message)
                            <dt class="col-sm-3">Message</dt>
                            <dd class="col-sm-9">
                                <div class="p-3 rounded" style="background: var(--cloud);">
                                    {!! nl2br(e($contactMessage->message)) !!}
                                </div>
                            </dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Actions</div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary"
                                onclick="openStatusModal({{ $contactMessage->id }}, '{{ $contactMessage->status }}')">
                            <i data-lucide="pencil"></i> Change Status
                        </button>

                        <a href="mailto:{{ $contactMessage->email }}" class="btn btn-primary">
                            <i data-lucide="reply"></i> Reply via Email
                        </a>

                        @if($contactMessage->phone)
                            <a href="tel:{{ $contactMessage->phone }}" class="btn btn-success">
                                <i data-lucide="phone"></i> Call
                            </a>
                        @endif

                        <form action="{{ route('admin.contact-messages.destroy', $contactMessage->id) }}"
                              method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i data-lucide="trash-2"></i> Delete Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">Status</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Current Status:</span>
                        <span class="badge {{ $contactMessage->status_badge }} status-badge"
                              data-id="{{ $contactMessage->id }}"
                              data-status="{{ $contactMessage->status }}"
                              onclick="openStatusModal({{ $contactMessage->id }}, '{{ $contactMessage->status }}')"
                              style="cursor: pointer;">
                            {{ $contactMessage->status_label }}
                        </span>
                    </div>
                    <small class="text-muted">Click the status badge to change it.</small>
                </div>
            </div>
        </div>
    </div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="statusForm">
                    <input type="hidden" id="messageId" name="messageId">
                    <div class="mb-3">
                        <label for="statusSelect" class="form-label">Status</label>
                        <select class="form-select" id="statusSelect" name="status" required>
                            <option value="new">New</option>
                            <option value="read">Read</option>
                            <option value="replied">Replied</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updateStatusBtn">Update Status</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Axios JS -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
$(document).ready(function() {
    window.openStatusModal = function(messageId, currentStatus) {
        $('#messageId').val(messageId);
        $('#statusSelect').val(currentStatus);
        $('#statusModal').modal('show');
    }

    $('#updateStatusBtn').on('click', function() {
        const messageId = $('#messageId').val();
        const newStatus = $('#statusSelect').val();

        axios.put(`/admin/contact-messages/${messageId}/status`, {
            status: newStatus
        }, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(function(response) {
            if (response.data.success) {
                $('#statusModal').modal('hide');

                const badgeClass = getBadgeClass(newStatus);
                const statusLabel = getStatusLabel(newStatus);
                $('.status-badge').removeClass('bg-primary bg-info bg-success bg-secondary')
                                  .addClass(badgeClass)
                                  .text(statusLabel)
                                  .attr('data-status', newStatus);

                const alert = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                    ${response.data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>`;
                $('.admin-content').prepend(alert);

                setTimeout(function() {
                    $('.admin-content > .alert').first().fadeOut();
                }, 3000);
            }
        })
        .catch(function(error) {
            console.error('Error updating status:', error);
            alert('Failed to update status. Please try again.');
        });
    });

    function getBadgeClass(status) {
        const classes = {
            'new': 'bg-primary',
            'read': 'bg-info',
            'replied': 'bg-success',
            'closed': 'bg-secondary'
        };
        return classes[status] || 'bg-secondary';
    }

    function getStatusLabel(status) {
        const labels = {
            'new': 'New',
            'read': 'Read',
            'replied': 'Replied',
            'closed': 'Closed'
        };
        return labels[status] || status;
    }
});
</script>
@endpush
