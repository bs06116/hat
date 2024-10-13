@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Sites</h5>
      <a href="{{ route('tenants.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i> Add New Site
      </a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Site Name</th>
            <th>Site Owner</th>
            <th>Domain</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($tenants as $tenant)
            <tr>
              <td>
                <i class="ti ti-building ti-md text-primary me-4"></i>
                <span class="fw-medium">{{ $tenant->name }}</span>
              </td>
              <td>
                {{ $tenant->user->first_name.' '.$tenant->user->last_name }}
              </td> 
              <td>
                {{ $tenant->domain->domain }}
              </td>
              <td>
                <div class="form-check form-switch mb-2">
                    <input data-status="{{ $tenant->user->status }}"  
                           data-id="{{ $tenant->user->id }}"  
                           class="form-check-input status-toggle" 
                           {{ $tenant->user->status == \App\UserStatus::ACTIVE->value ? 'checked' : '' }} 
                           type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">
                        {{ $tenant->user->status == \App\UserStatus::ACTIVE->value ? \App\UserStatus::ACTIVE->name : \App\UserStatus::DEACTIVE->name }}
                    </label>
                </div>
              </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical"></i>
                  </button>
                  <div class="dropdown-menu">
                    <form method="POST" action="{{ route('tenants.destroy', $tenant->id) }}" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button class="dropdown-item" type="submit"><i class="ti ti-trash me-2"></i> Delete</button>
                    </form>
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">No tenants found.</td>
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

 $(document).on('change', '.status-toggle', function () {
      var userId = $(this).data('id');
      var newStatus = $(this).is(':checked') ? '{{ \App\UserStatus::ACTIVE->value }}' : '{{ \App\UserStatus::DEACTIVE->value }}';
      var checkbox = $(this);

      $.ajax({
          url: '{{ route("tenants.toggleStatus") }}', // Add your toggle status route here
          method: 'POST',
          data: {
              _token: '{{ csrf_token() }}',
              user_id: userId,
              status: newStatus
          },
          success: function(response) {
            console.info(response.message);
              if (response.success) {
                  toastr.success(response.message); // Show success message
              } else {
                  toastr.error('Failed to change status.'); // Show error message
                  checkbox.prop('checked', !checkbox.is(':checked')); // Revert if the action fails
              }
          },
          error: function() {
              toastr.error('An error occurred while changing the status.'); // Show error message
              checkbox.prop('checked', !checkbox.is(':checked')); // Revert if AJAX fails
          }
      });
  });
</script>
<script>
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
@endpush

