@extends('site.layouts.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
    <h5 class="card-header">Job Creation Form</h5>
    <form method="POST" action="{{ route('jobs.store') }}" class="card-body">
      @csrf

      <div class="row">
      <!-- Passenger Name -->
      <div class="col-md-6 mt-4">
        <label for="passenger_name" class="form-label">Passenger Name</label>
        <input type="text" id="passenger_name" name="passenger_name" value="{{ old('passenger_name') }}"
        class="form-control" />

        @error('passenger_name')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>

      <!-- passenger_contact_number -->
      <div class="col-md-6 mt-4">
        <label for="passenger_contact_number" class="form-label">Passenger Contact Number</label>
        <input type="text" id="passenger_contact_number" name="passenger_contact_number"
        value="{{ old('passenger_contact_number') }}" class="form-control" />
        @error('passenger_contact_number')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      </div>
      <div class="row">
      <!-- Department Selection -->
      <div class="col-md-6 mt-4">
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
      <div class="col-md-6 mt-4">
        <label for="job_title" class="form-label">Job Title</label>
        <select id="job_title" name="title" class="form-control" required>
        <option value="">Select a Job Title</option>
        </select>
        @error('title')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      </div>

      <!-- Location Selection -->
      <div class="row">

      <div class="col-md-6 mt-4">
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

      <!-- Hourly Pay -->
      <div class="col-md-6 mt-4">
        <label for="hourly_pay" class="form-label">Hourly Pay (&pound;)</label>
        <input type="number" id="hourly_pay" name="hourly_pay" value="{{ old('hourly_pay') }}" class="form-control"
        step="0.01" required />
        @error('hourly_pay')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>

      </div>

      <!-- Start Date and End Date (in one row) -->
      <div class="row mt-4">
      <div class="col-md-6">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="form-control"
        required />
        @error('start_date')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <div class="col-md-6">
        <label for="end_date" class="form-label">End Date</label>
        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="form-control"
        required />
        @error('end_date')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      </div>

      <!-- Start Time and End Time (in one row) -->
      <div class="row mt-4">
      <div class="col-md-6">
        <label for="start_time" class="form-label">Start Time</label>
        <input type="time" id="start_time" name="start_time" class="form-control" required />
        @error('start_time')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <div class="col-md-6">
        <label for="end_time" class="form-label">End Time</label>
        <input type="time" id="end_time" name="end_time" class="form-control" required />
        @error('end_time')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      </div>
      <div class="row mt-4">
      <div class="col-md-4">
        <label for="wait_return" class="form-label">Wait & Return</label>
        <input type="text" id="wait_return" name="wait_return" class="form-control"  />
        @error('wait_return')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <div class="col-md-4">
        <label for="return_time" class="form-label">Return Time</label>
        <input type="text" id="return_time" name="return_time" class="form-control"  />
        @error('return_time')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <div class="col-md-4">

        <label for="destination_time" class="form-label">Destination Time</label>
        <input type="text" id="destination_time" name="destination_time" class="form-control"  />
        @error('destination_time')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      </div>

      <!-- Job Description -->
      <div class="mt-4">
      <label for="description" class="form-label">Job Description</label>
      <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
      @error('description')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>

      <!-- Pickup and Drop Address -->
      <div class="mt-4">
      <label for="addresses" class="form-label">Addresses</label>
      <div id="addresses">
        <!-- Pickup Address -->
        <div class="input-group mb-3">
        <input type="text" name="addresses[]" class="form-control" placeholder="Pickup Address" required />
        </div>
        <!-- Drop Address -->
        <div class="input-group mb-3">
        <input type="text" name="addresses[]" class="form-control" placeholder="Drop Address" required />
        <button type="button" class="btn btn-primary add-address">Add</button>
        </div>
      </div>
      </div>


      <!-- add input checkbo box for round trip -->
      <!-- <div class="mt-4">
      <label for="round_trip" class="form-label"> is Round Trip?</label>
      <input type="checkbox" name="round_trip">

      </div> -->

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
    $(document).ready(function () {
    // Add new address field
    $(document).on('click', '.add-address', function () {
      const newField = `
        <div class="input-group mb-3">
        <input type="text" name="addresses[]" class="form-control" placeholder="Drop Address" required />
        <button type="button" class="btn btn-danger remove-address">Remove</button>
        </div>`;
      $('#addresses').append(newField);
    });

    // Remove address field
    $(document).on('click', '.remove-address', function () {
      $(this).closest('.input-group').remove();
    });
    });
  </script>
@endpush
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
    $(document).ready(function () {
    $('#department').change(function () {
      var departmentId = $(this).val();
      if (departmentId) {
      $.ajax({
        url: "{{ route('get.job.title', ':id') }}".replace(':id', departmentId),
        type: 'GET',
        dataType: 'json',
        success: function (data) {
        $('#job_title').empty().append('<option value="">Select a Job Title</option>');
        $.each(data, function (key, value) {
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