@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Job Details</h5>
        </div>
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
                    <p><strong>Start Date:</strong>{{ $job->start_date->format('d-m-Y') }} </p>
                </div>
                <div class="col-md-6">
                    <p><strong>End Date:</strong>{{ $job->end_date->format('d-m-Y') }} </p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Shift Start Time:</strong> {{ $job->start_time}}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Shift End Time:</strong> {{ $job->end_time}}</p>
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

            <!-- if assigned 0 then it means driver accept current offer
            if assigned 1 then it means driver won the job
            if assigned 2 then it means driver reoffer the job
            if assigned 3 then it means admin counter offer the job
            if assigned 4 then it means driver counter offer to job second time
            if assigned 5 then it means admin reject the offer to driver
            -->
            @if($getDriverBidPrice?->assigned == 1)
                    <p class="text-success">You have won this job.</p>
            @elseif($getDriverBidPrice?->assigned == 5)
                    <p class="text-danger">Admin has Reject the offer.</p>
            @else
                        <form action="{{ route('jobs.submitBid', $job) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <!-- Radio buttons group -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="bid_offer" value="1" id="accept_offer"
                                        {{$getDriverBidPrice?->assigned == 0 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="accept_offer">Accept Offer</label>
                                </div>
                                @php
                                    if ($getDriverBidPrice?->assigned == 2 || $getDriverBidPrice?->assigned == 3  || $getDriverBidPrice?->assigned == 4 ) {
                                        $checkBid = 'checked';
                                    } else {
                                        $checkBid = '';
                                    }    
                                @endphp
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="bid_offer" value="2" id="reoffer" {{$checkBid}}/>
                                    <label class="form-check-label" for="reoffer">Bid</label>
                                </div>
                            </div>
                            @php
                                if ($getDriverBidPrice?->assigned === 2 || $getDriverBidPrice?->assigned === 3 || $getDriverBidPrice?->assigned === 4) {
                                    $display = 'block';

                                } else {
                                    $display = 'none';
                                }    
                            @endphp 
                            <!-- Hidden by default; displayed when "ReOffer" is selected -->
                            <div id="bid_price_section" class="mb-3"
                                style="display:  {{$display}}">
                                <label for="bid_price" class="form-label">Your Hourly Offer</label>
                                <input type="number" class="form-control form-control-sm w-25" id="bid_price" name="bid_price"
                                    value="{{ optional($getDriverBidPrice)->bid_price ?? $job->hourly_pay }}"
                                    placeholder="Enter your hourly rate" step="0.01" min="0">
                            </div>
                            @php
                                if ($getDriverBidPrice?->assigned === 0 || $getDriverBidPrice?->assigned === 2 || $getDriverBidPrice?->assigned === 4) {
                                    $hasBid = 'disabled';
                                } else {
                                    $hasBid = '';
                                }    
                            @endphp
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary mt-3 {{$hasBid}}">
                                <i class="bi bi-check-lg"></i> Submit
                            </button>
                        </form>
                        @push('scripts')
                            <script>
                                document.querySelectorAll('input[name="bid_offer"]').forEach(radio => {
                                    radio.addEventListener('change', function () {
                                        document.getElementById('bid_price_section').style.display =
                                            this.value === '2' ? 'block' : 'none';
                                    });
                                });
                            </script>
                        @endpush

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
@endsection