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
        <b class="card-title">{{ $job->booking_ref }}</b>

      </div>
      
      <div class="card-body">
      <div class="row mb-3">
          <div class="col-md-6">
            <p><strong>Passenger Name:</strong> {{ $job->passenger_name }} </p>
          </div>
          <div class="col-md-6">
            <p><strong>Passenger Contact Number:</strong> {{ $job->passenger_contact_number  }}</p>
          </div>
        </div>
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
        @if(count($addresses) > 0)
          @foreach($addresses as $index => $address)
            <div class="row mb-3">
              <div class="col-md-12">
                <p><strong>{{ $index === 0 ? 'Pickup Address' : 'Drop Address' }}:</strong> {{ $address }}</p>
              </div>
            </div>
          @endforeach
        @endif
        

        <!-- Bidders Section -->
         <!-- if assigned 0 then it means driver accept current offer
            if assigned 1 then it means driver won the job
            if assigned 2 then it means driver reoffer the job
            if assigned 3 then it means admin counter offer the job
            if assigned 4 then it means driver counter offer to job second time
            if assigned 5 then it means admin reject the offer to driver
            -->
        <h5>Bidders</h5>
        @if($job->driversBids->isEmpty())
      <p>No bids have been placed for this job yet.</p>
    @else
      <table class="table table-striped">
        <thead>
        <tr>
          <th>Driver</th>
          <th>Assigned Date</th>
          <th>Note</th>
          <th>Driver Offer</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($job->driversBids as $bid)
        <form action="{{ route('job.assign', ['job' => $job->id, 'driver' => $bid->driver_id]) }}" method="POST">
          @csrf
          <tr>
          <td>
          {{ $bid->driver->first_name . ' ' . $bid->driver->last_name }}
          </td>
          <td>
          {{ $bid->bid_date?->format('d-m-Y') }}
          </td>
          <td>
          {{ $bid->note }}
          </td>
          <td>
          <!-- {{ $bid->bid_price }} -->
          
        <input 
        class="form-control" 
        type="text" 
        name="bid_price" 
        value="{{ $bid->bid_price }}"
        >
       
          </td>
          <td>
          @if($bid->assigned == 1)
        <button class="btn btn-secondary btn-sm" disabled>
        Assigned
        </button>
      @else
      @if($bid->assigned != 5)
      <div class="d-flex gap-2">
      <button type="submit" class="btn btn-danger btn-sm" name="action" value="reject">
      Reject Offer
      </button>
      @if($bid->assigned === 0 || $bid->assigned === 2)
      <button type="submit" class="btn btn-primary btn-sm" name="action" value="counter_offer">
      Counter Offer
      @endif
      </button>
      <button type="submit" class="btn btn-primary btn-sm" name="action" value="assign">
      Assign Job
      </button>
      @endif
      </div>
    @endif
          </td>

          </tr>
        </form>

    @endforeach
        </tbody>
      </table>
  @endif
      </div>
    </div>
  </div>
</div>
@endsection