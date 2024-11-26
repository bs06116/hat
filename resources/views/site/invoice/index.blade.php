@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Invoices</h5>
      <!-- <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i> Add New Site Admin
      </a> -->
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Driver</th>
            <th>Total Hours</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($invoices as $invoice)
            <tr>
            
              <td>
                {{ $invoice->user->first_name . ' ' . $invoice->user->last_name }}
              </td>
              <td>{{ $invoice->total_hours }}</td>
              <td>{{ $invoice->total_amount }}</td>
              <td>
                <span class="status-label" id="status-label-{{ $invoice->id }}">
                  {{ $invoice->is_approved ? 'Approved' : 'In Process' }}
                </span>
              </td>
              <td>
                <button 
                  data-id="{{ $invoice->id }}" 
                  class="btn btn-sm btn-toggle-approval {{ $invoice->is_approved ? 'btn-success' : 'btn-warning' }}">
                  {{ $invoice->is_approved ? 'Unapprove' : 'Approve' }}
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center">No Invoice found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    // Toggle approval status
    $('.btn-toggle-approval').on('click', function() {
        const invoiceId = $(this).data('id');
        const button = $(this);
        const statusLabel = $('#status-label-' + invoiceId);

        $.ajax({
            url: '{{ route("invoices.toggleApproval") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                invoice_id: invoiceId
            },
            success: function(response) {
                if (response.success) {
                    // Update the button text and class based on the new approval status
                    button.text(response.is_approved ? 'Unapprove' : 'Approve')
                          .toggleClass('btn-success btn-warning', response.is_approved);

                    // Update the status label
                    statusLabel.text(response.is_approved ? 'Approved' : 'In Process');
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                toastr.error('An error occurred while updating the invoice status.');
            }
        });
    });
</script>
@endpush
