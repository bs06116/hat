@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Sites Driver</h5>
      <a href="{{ route('drivers.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i> Add New Site Driver
      </a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Status</th>
            <th>Created Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($drivers as $driver)
            <tr>
              <td>
                <i class="ti ti-building ti-md text-primary me-4"></i>
                <span class="fw-medium">{{ $driver->first_name.' '.$driver->last_name }}</span>
              </td>
              <td>
                {{ $driver->email }}
              </td>
              <td>
              @foreach($driver->departments as $department)
                            {{ $department->name }}@if(!$loop->last), @endif
                        @endforeach
              </td>
             
              <td>
              <div class="d-flex justify-content-between align-items-center">
              <span class="text-danger">Suspended</span>

                  <div class="form-check form-switch mb-2">
                    <input data-status="{{ $driver->status }}"  
                          data-id="{{ $driver->id }}"  
                          class="form-check-input status-toggle" 
                          {{ $driver->status->value == \App\UserStatus::ACTIVE->value ? 'checked' : '' }} 
                          type="checkbox" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                  </div>
                  <span class="text-success">Active</span>
              </div>
              </td>
              <td>
                {{ $driver->created_at->format('d-m-Y') }}
              </td> 
              <td>
              <a href="{{route('drivers.edit', $driver->id)}}">
                <button class="btn btn-warning"><i class="ti ti-edit me-2"></i></button>
              </a>

              <form method="POST" action="{{ route('drivers.destroy', $driver->id) }}"  onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger"><i class="ti ti-trash me-2"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">No Driver found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <div class="row">
   
    <div class="col-md-6 d-flex justify-content-end">
        {{ $drivers->links('pagination::bootstrap-5') }}
    </div>
</div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>

 $(document).on('change', '.status-toggle', function () {
      var driverId = $(this).data('id');
      var newStatus = $(this).is(':checked') ? '{{ \App\UserStatus::ACTIVE->value }}' : '{{ \App\UserStatus::DEACTIVE->value }}';
      var checkbox = $(this);

      $.ajax({
          url: '{{ route("drivers.toggleStatus") }}', // Add your toggle status route here
          method: 'POST',
          data: {
              _token: '{{ csrf_token() }}',
              driver_id: driverId,
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

