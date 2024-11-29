@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Approved Invoices</h5>
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
            <th>Download</th>

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
             
                <a href="{{ route('site.invoice.pdf', $invoice->id) }}">
                <i class="ti ti-download ti-md text-primary me-4"></i></a>
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


</script>
@endpush
