@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Job Details</h5>
    </div>

    <div class="card mb-4">
      <div class="card-header">
        <h4 class="card-title">{{ $job->job_department_title?->job_title }}</h4>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <p><strong>Department:</strong>
              @foreach($job->departments as $department)
                {{ $department->name }}@if(!$loop->last), @endif
              @endforeach
            </p>
          </div>
          <div class="col-md-6">
            <p><strong>Location:</strong> {{ $job->location->name }}</p>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <p><strong>Start Date:</strong> {{ $job->start_date->format('d-m-Y') }} </p>
          </div>
          <div class="col-md-6">
            <p><strong>End Date:</strong> {{ $job->end_date->format('d-m-Y')  }}</p>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <p><strong>Shift Start Time:</strong> {{   date('h:i A', strtotime($job->start_time)) }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Shift End Time:</strong> {{   date('h:i A', strtotime($job->end_time)) }}</p>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <p><strong>Hourly Pay:</strong> £{{ number_format($job->hourly_pay, 2) }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Description:</strong> {{ $job->description }}</p>
          </div>
        </div>

        <!-- Bidders Section -->
        <h5>Bidders</h5>
        @if($job->driversBids->isEmpty())
          <p>No bids have been placed for this job yet.</p>
        @else
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Driver</th>
                <th>Assigned Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($job->driversBids as $bid)
                <tr>
                  <td>{{ $bid->driver->first_name.' '.$bid->driver->last_name }}</td>
                  <td>
                  {{ $bid->bid_date?->format('d-m-Y') }}
                    <!-- @if($bid->assigned)
                      <span class="badge bg-success">Assigned</span>
                    @else
                      <span class="badge bg-danger">Not Assigned</span>
                    @endif -->
                  </td>
                  <td>
                    @if(!$bid->assigned)
                      <form action="{{ route('job.assign', parameters: ['job' => $job->id, 'driver' => $bid->driver_id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Assign Job</button>
                      </form>
                    @else
                      <button class="btn btn-secondary btn-sm" disabled>Assigned</button>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
