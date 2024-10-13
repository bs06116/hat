@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Sites Admin</h5>
      <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i> Add New Site Admin
      </a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Created Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($users as $user)
            <tr>
              <td>
                <i class="ti ti-building ti-md text-primary me-4"></i>
                <span class="fw-medium">{{ $user->first_name.' '.$user->last_name }}</span>
              </td>
              <td>
                {{ $user->email }}
              </td> 
             
              <td>
                <div class="form-check form-switch mb-2">
                    <input data-status="{{ $user->status }}"  
                           data-id="{{ $user->id }}"  
                           class="form-check-input status-toggle" 
                           {{ $user->status == \App\UserStatus::ACTIVE->value ? 'checked' : '' }} 
                           type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">
                        {{ $user->status == \App\UserStatus::ACTIVE->value ? \App\UserStatus::ACTIVE->name : \App\UserStatus::DEACTIVE->name }}
                    </label>
                </div>
              </td>
              <td>
                {{ $user->created_at->format('d-m-Y') }}
              </td> 
              <td>
              <a href="{{route('users.edit', $user->id)}}">
                <button class="dropdown-item"><i class="ti ti-edit me-2"></i></button>
              </a>

              <form method="POST" action="{{ route('users.destroy', $user->id) }}"  onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button class="dropdown-item" type="submit"><i class="ti ti-trash me-2"></i></button>
                </form>
  
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">No User found.</td>
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
          url: '{{ route("users.toggleStatus") }}', // Add your toggle status route here
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

