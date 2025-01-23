@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Notification Settings</h5>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Notification Type</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            <tr>
              <td>Job Won</td>
              <td>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="form-check form-switch mb-2">
                    <input  @php if( in_array( 'job_won', $notifications->where('status', \App\NotificationStatus::ACTIVE->value )->pluck('notification_type')->toArray() )) echo 'checked' @endphp  data-type="job_won" class="form-check-input status-toggle" type="checkbox" id="notificationJobWon" >
                    <label class="form-check-label" for="notificationJobWon"></label>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Invoice</td>
              <td>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="form-check form-switch mb-2">
                    <input  @php if( in_array( 'invoice', $notifications->where('status', \App\NotificationStatus::ACTIVE->value )->pluck('notification_type')->toArray() )) echo 'checked' @endphp  data-type="invoice" class="form-check-input status-toggle" type="checkbox" id="notificationInvoice">
                    <label class="form-check-label" for="notificationInvoice"></label>
                  </div>
                </div>
              </td>
            </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
document.querySelectorAll('.status-toggle').forEach(toggle => {
  toggle.addEventListener('change', function() {
    const type = this.dataset.type;
    const status = this.checked ? 'active' : 'inactive';

    // Disable the toggle temporarily
    this.disabled = true;

    fetch('{{ route("notifications.update") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ type, status })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        toastr.success(data.message); // Show success message
      } else {
        toastr.error('Failed to update notification status'); // Show error message
        // Revert toggle state in case of failure
        this.checked = !this.checked;
      }
    })
    .catch(error => {
        toastr.error(error.message); // Show error message
     // alert('An error occurred: ' + error.message);
      // Revert toggle state in case of error
      this.checked = !this.checked;
    })
    .finally(() => {
      // Re-enable the toggle
      this.disabled = false;
    });
  });
});

</script>
@endsection
