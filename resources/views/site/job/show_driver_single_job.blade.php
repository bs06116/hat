@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Job Details</h5>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">{{ $job->job_department_title?->job_title }}</h3>
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
                        <p><strong>Start Date:</strong> </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>End Date:</strong> </p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Shift Start Time:</strong> </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Shift End Time:</strong> </p>
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

                <!-- Display assignment message -->
                @if($assignedBid)
                    @if($isAssignedToMe)
                        <p class="text-success">You have won this job.</p>
                    @else
                        <p class="text-danger">This job is already won to another driver.</p>
                    @endif
                    

                @endif
 <!-- Job Bid Message -->
 @if(!$assignedBid && !$isAssignedToMe)
                @if($hasBid)
                    <p class="text-warning">You have already bid for this job.</p>
                @else
                    <form action="{{ route('jobs.submitBid', $job) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Submit Bid</button>
                    </form>
                @endif
                @endif

                <!-- Display message after bid submission -->
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

            
            </div>
        </div>
    </div>
</div>
@endsection
