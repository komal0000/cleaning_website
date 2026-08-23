@extends('admin.layouts.app')

@section('title', 'Contact Messages')
@section('page-title', 'Contact Messages')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Contact Messages',
        'description' => 'Enquiries submitted through the public contact form.',
    ])

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <select id="statusFilter" class="form-select" style="width: auto;">
                    <option value="">All Status</option>
                    <option value="new">New</option>
                    <option value="read">Read</option>
                    <option value="replied">Replied</option>
                    <option value="closed">Closed</option>
                </select>
            </div>

            <div class="table-responsive">
                <table id="contactMessagesTable" class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
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

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
.status-badge {
    cursor: pointer;
}
.message-preview {
    max-width: 200px;
    cursor: help;
}
</style>
@endpush

@push('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<!-- Axios JS -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
$(document).ready(function() {
    const table = $('#contactMessagesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.contact-messages.data") }}',
            data: function(d) {
                d.status = $('#statusFilter').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'service', name: 'service' },
            {
                data: 'status',
                name: 'status',
                render: function(data, type, row) {
                    const badgeClass = getBadgeClass(data);
                    return `<span class="badge ${badgeClass} status-badge" data-id="${row.id}" data-status="${data}" onclick="openStatusModal(${row.id}, '${data}')">${row.status_label}</span>`;
                }
            },
            {
                data: 'created_at',
                name: 'created_at',
                render: function(data) {
                    return new Date(data).toLocaleDateString();
                }
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <div class="table-actions">
                            <a href="${data.view}" class="btn btn-sm btn-light" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button" onclick="deleteMessage(${row.id})" class="btn btn-sm btn-outline-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        responsive: true
    });

    $('#statusFilter').on('change', function() {
        table.draw();
    });

    window.getBadgeClass = function(status) {
        const classes = {
            'new': 'bg-primary',
            'read': 'bg-info',
            'replied': 'bg-success',
            'closed': 'bg-secondary'
        };
        return classes[status] || 'bg-secondary';
    }

    window.openStatusModal = function(messageId, currentStatus) {
        $('#messageId').val(messageId);
        $('#statusSelect').val(currentStatus);
        $('#statusModal').modal('show');
    }

    function showAlert(message) {
        const alert = `<div class="alert alert-success alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;
        $('.admin-content').prepend(alert);
        setTimeout(function() {
            $('.admin-content > .alert').first().fadeOut();
        }, 3000);
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
                table.draw();
                showAlert(response.data.message);
            }
        })
        .catch(function(error) {
            console.error('Error updating status:', error);
            alert('Failed to update status. Please try again.');
        });
    });

    window.deleteMessage = function(messageId) {
        if (confirm('Are you sure you want to delete this message?')) {
            axios.delete(`/admin/contact-messages/${messageId}`, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(function(response) {
                table.draw();
                showAlert('Message deleted successfully.');
            })
            .catch(function(error) {
                console.error('Error deleting message:', error);
                alert('Failed to delete message. Please try again.');
            });
        }
    }
});
</script>
@endpush
