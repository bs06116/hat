@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Jobs Won</h5>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Department</th>
            <th>Base Location</th>
            <th>Job Title</th>
            <th>Shift Time</th>
            <th>Hourly Pay (&pound;)</th>
            <th>Status</th>
            <th>Action</th>

          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($wonJobs as $job)
            <tr>
              <td> @foreach($job->departments as $department)
                            {{ $department->name }}@if(!$loop->last), @endif
                        @endforeach
              </td>
              <td>{{ $job->location->name }}</td>
              <td>{{ $job->title }}</td>
              <td>{{ $job->start_time }} - {{ $job->end_time }}</td>
              <td>£{{ $job->hourly_pay }}</td>
              <td></td>
              <td><a href="{{ route('jobs.showAavailableJob', ['job' => $job->id]) }}" class="btn btn-primary">
                  <i class="ti ti-view me-2"></i> View
                </a></td>

            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center">No won jobs at the moment.</td>
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