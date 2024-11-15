@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">
    <h5 class="card-header">Job Creation Form</h5>
    <form method="POST" action="{{ route('jobs.store') }}" class="card-body">
      @csrf

      <!-- Department Selection -->
      <div class="mt-4">
    <label for="department" class="form-label">Department</label>
    <select name="department_ids[]" id="department" class="form-control" required>
    <option value="">Select a Department</option>
        @foreach($departments as $department)
            <option value="{{ $department->id }}">
                              {{ $department->name }}
            </option>
        @endforeach
    </select>
    @error('department_ids')
        <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
</div>
<!-- Job Title -->
      <div class="mt-4">
          <label for="title" class="form-label">Job Title</label>
          <select id="job_title" name="title" class="form-control" required>
        <option value="">Select a Job Title</option>
    </select>
        <!-- <label for="title" class="form-label">Job Title</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" required />
        @error('title')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror -->
      </div>
      <!-- Location Selection -->
      <div class="mt-4">
        <label for="location" class="form-label">Location</label>
        <select name="location_id" id="location" class="form-control" required>
          <option value="">Select a Location</option>
          @foreach($locations as $location)
            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
              {{ $location->name }}
            </option>
          @endforeach
        </select>
        @error('location_id')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

      

      <!-- Start Date -->
      <div class="mt-4">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="form-control" required />
        @error('start_date')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- End Date -->
      <div class="mt-4">
        <label for="end_date" class="form-label">End Date</label>
        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="form-control" required />
        @error('end_date')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mt-4">

    <label for="start_time">Start Time</label>
    <input type="time" id="start_time" name="start_time" class="form-control" required>
    @error('end_date')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
</div>

<div class="mt-4">
<label for="end_time">End Time</label>
    <input type="time" id="end_time" name="end_time" class="form-control" required>
</div>

      <!-- Hourly Pay -->
      <div class="mt-4">
        <label for="hourly_pay" class="form-label">Hourly Pay (&pound;)</label>
        <input type="number" id="hourly_pay" name="hourly_pay" value="{{ old('hourly_pay') }}" class="form-control" step="0.01" required />
        @error('hourly_pay')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>
<!-- Job Description -->
<div class="mt-4">
    <label for="description" class="form-label">Job Description</label>
    <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
    @error('description')
        <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
</div>
      <!-- Submit and Cancel -->
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-4">Submit</button>
        <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
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
<script>
    $(document).ready(function() {
        $('#department').change(function() {
            var departmentId = $(this).val();
            if (departmentId) {
                $.ajax({
                  url: "{{ route('get.job.title', ':id') }}".replace(':id', departmentId),
                  type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#job_title').empty().append('<option value="">Select a Job Title</option>');
                        $.each(data, function(key, value) {
                            $('#job_title').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#job_title').empty().append('<option value="">Select a Job Title</option>');
            }
        });
    });
</script>
@endpush
