@extends('site.layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Jobs</h5>
      <a href="{{ route('jobs.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i> Add New Job
      </a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
          <th>Booking Ref</th>
            <th>Job Title</th>
            <th>Location</th>
            <th>Department</th>
            <th>Hourly Pay (&pound;)</th>
            <!-- <th>is Round Trip</th> -->
            <th>Created Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($jobs as $job)
            <tr>
            <td>
                <i class=" text-primary me-4"></i>
                <span class="fw-medium">{{ $job->booking_ref }}</span>
              </td>
              <td>
                <i class=" text-primary me-4"></i>
                <span class="fw-medium">{{ $job->job_department_title?->job_title }}</span>
              </td>
              <td>
              {{$job->location?->name}}
              </td>
              <td>  @foreach($job->departments as $department)
                                    {{ $department->name }}@if(!$loop->last), @endif
                     @endforeach
              </td> 
              <td>{{ $job->hourly_pay }}</td> 
              <!-- <td>{{ $job->round_trip == 1?'Yes':'No' }}</td>  -->
              <td>{{ $job->created_at->format('d-m-Y') }}</td> 

              <td>
             <a href="{{ route( 'jobs.show',  $job->id) }}" class="btn btn-primary">
                  <i class="ti ti-view me-2"></i> View
                </a>
                <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-warning">
                  <i class="ti ti-edit me-2"></i> Edit
                </a>
                <form method="POST" action="{{ route('jobs.destroy', $job->id) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this job?');" 
                      style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger"><i class="ti ti-trash me-2"></i></button>
                </form>
              </td>
            </tr>            
          @empty
            <tr>
              <td colspan="6" class="text-center">No Jobs found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <div class="row">
   
    <div class="col-md-6 d-flex justify-content-end">
        {{ $jobs->links('pagination::bootstrap-5') }}
    </div>
</div>

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
