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
        <div class="row">
        <div class="col-md-6">

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
        <div class="col-md-6">

          <label for="location" class="form-label">Vehicle</label>
          <select name="vehicle_type" id="vehicle_type" class="form-control" required>
          <option value="">Vehicle Type</option>
          <option value="5seater">5 seater</option>
          <option value="7seater">7 seater</option>
          <option value="9seater">9 seater</option>
          <option value="Iw">1 WAV</option>
          </select>
          @error('vehicle_type')
        <div class="mt-2 text-danger">{{ $message }}</div>
      @enderror
        </div>
        </div>
      </div>

      <!-- Pay Type -->
      <div class="col-md-6 mt-4">
        <div class="row">
        <div class="col-md-6">
          <label for="pay_type" class="form-label">Pay Type</label>
          <select name="pay_type" id="pay_type" class="form-control" required>
          <option value="">Select Pay Type</option>
          <option value="hourly" {{ old('pay_type') == 'hourly' ? 'selected' : '' }}>Hourly</option>
          <option value="shift" {{ old('pay_type') == 'shift' ? 'selected' : '' }}>Per Shift</option>
          </select>
          @error('pay_type')
        <div class="mt-2 text-danger">{{ $message }}</div>
      @enderror
        </div>
        <div class="col-md-6">
          <label for="hourly_pay" class="form-label"><span id="pay_label">Pay</span> (&pound;)</label>
          <input type="number" id="hourly_pay" name="hourly_pay" value="{{ old('hourly_pay') }}"
          class="form-control" step="0.01" required />
          @error('hourly_pay')
        <div class="mt-2 text-danger">{{ $message }}</div>
      @enderror
        </div>
        </div>
      </div>

      </div>

      <!-- Start Date and End Date (in one row) -->
      <div class="row mt-4">
      <div class="col-md-6">
        <label for="start_date" class="form-label"><span id="journey_date_label">Journey Start Date</span></label>
        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="form-control"
        required />
        @error('start_date')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <div class="col-md-6 end_date_container">
        <label for="end_date" class="form-label">Journey End Date</label>
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
        <label for="start_time" class="form-label"><span id="journey_time_label">Journey Start Time</span></label>
        <input type="time" id="start_time" name="start_time" class="form-control" required />
        @error('start_time')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <div class="col-md-6 end_time_container">
        <label for="end_time" class="form-label">Journey End Time</label>
        <input type="time" id="end_time" name="end_time" class="form-control" required />
        @error('end_time')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      </div>
      <div class="row">
      <!-- Local Authorities -->
      <div class="col-md-6 mt-4">
        <label for="local_authorities" class="form-label">Local Authorities</label>
        <select name="local_authorities" id="local_authorities" class="form-control">
        <option value="">Select Local Authorities</option>
        <option value="City of London Corporation">City of London Corporation</option>
        <option value="City of Westminster">City of Westminster</option>
        <option value="LB Barking and Dagenham">LB Barking and Dagenham</option>
        <option value="LB Barnet">LB Barnet</option>
        <option value="LB Bexley">LB Bexley</option>
        <option value="LB Brent">LB Brent</option>
        <option value="LB Bromley">LB Bromley</option>
        <option value="LB Camden">LB Camden</option>
        <option value="LB Croydon">LB Croydon</option>
        <option value="LB Ealing">LB Ealing</option>
        <option value="LB Enfield">LB Enfield</option>
        <option value="LB Hackney">LB Hackney</option>
        <option value="LB Hammersmith &amp; Fulham">LB Hammersmith &amp; Fulham</option>
        <option value="LB Haringey">LB Haringey</option>
        <option value="LB Harrow">LB Harrow</option>
        <option value="LB Havering">LB Havering</option>
        <option value="LB Hillingdon">LB Hillingdon</option>
        <option value="LB Hounslow">LB Hounslow</option>
        <option value="LB Islington">LB Islington</option>
        <option value="LB Lambeth">LB Lambeth</option>
        <option value="LB Lewisham">LB Lewisham</option>
        <option value="LB Merton">LB Merton</option>
        <option value="LB Newham">LB Newham</option>
        <option value="LB Redbridge">LB Redbridge</option>
        <option value="LB Richmond Upon Thames">LB Richmond Upon Thames</option>
        <option value="LB Southwark">LB Southwark</option>
        <option value="LB Sutton">LB Sutton</option>
        <option value="LB Tower Hamlets">LB Tower Hamlets</option>
        <option value="LB Waltham Forest">LB Waltham Forest</option>
        <option value="LB Wandsworth">LB Wandsworth</option>
        <option value="RB Greenwich">RB Greenwich</option>
        <option value="RB Kensington &amp; Chelsea">RB Kensington &amp; Chelsea</option>
        <option value="RB Kingston Upon Thames">RB Kingston Upon Thames</option>
        </select>

        @error('journey_date')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <div class="col-md-6 mt-4">
        <label for="trust" class="form-label">Trusty</label>
        <select name="trust" id="trust" class="form-control">
        <option value="">Select Trust</option>
        <option value="BROMLEY HEALTHCARE">BROMLEY HEALTHCARE</option>
        <option value="CHELSEA CORE">CHELSEA CORE</option>
        <option value="CHELSEA COVID SUPPORT">CHELSEA COVID SUPPORT</option>
        <option value="CHELSEA REC">CHELSEA REC</option>
        <option value="CLCH TAXIS CLCH01-CLCH11">CLCH TAXIS CLCH01-CLCH11</option>
        <option value="CNWL (Ealing)">CNWL (Ealing)</option>
        <option value="CNWL QTS">CNWL QTS</option>
        <option value="CNWL SCHOOL VAC">CNWL SCHOOL VAC</option>
        <option value="CNWL STP09">CNWL STP09</option>
        <option value="CNWL02 MENTAL HEALTH">CNWL02 MENTAL HEALTH</option>
        <option value="COLLIERS WOOD RENALS">COLLIERS WOOD RENALS</option>
        <option value="CROYDON CORE">CROYDON CORE</option>
        <option value="CROYDON TAXI / ANTI COAG">CROYDON TAXI / ANTI COAG</option>
        <option value="CROYDON VITA">CROYDON VITA</option>
        <option value="DARENT VALLEY">DARENT VALLEY</option>
        <option value="GOSH ADDITIONAL ROLLING COST">GOSH ADDITIONAL ROLLING COST</option>
        <option value="GOSH CORE">GOSH CORE</option>
        <option value="GOSH PTS">GOSH PTS</option>
        <option value="GOSH RENALS">GOSH RENALS</option>
        <option value="GOSH TAXI">GOSH TAXI</option>
        <option value="HAMMERSMITH AND FULHAM &amp; KENSINGTON &amp; CHELSEA">HAMMERSMITH AND FULHAM &amp;
          KENSINGTON &amp; CHELSEA</option>
        <option value="HILLCADV">HILLCADV</option>
        <option value="HILLINGDON CCG O/A">HILLINGDON CCG O/A</option>
        <option value="HILLINGDON CORE">HILLINGDON CORE</option>
        <option value="HILLINGDON MENTAL HEALTH">HILLINGDON MENTAL HEALTH</option>
        <option value="IMPERIAL">IMPERIAL</option>
        <option value="KINGS COLLEGE">KINGS COLLEGE</option>
        <option value="KINGSTON CORE">KINGSTON CORE</option>
        <option value="KINGSTON OVERACTIVITY">KINGSTON OVERACTIVITY</option>
        <option value="L&amp;G CORE">L&amp;G CORE</option>
        <option value="L&amp;G TAXI / TT's">L&amp;G TAXI / TT's</option>
        <option value="LAS">LAS</option>
        <option value="MANCHESTER">MANCHESTER</option>
        <option value="MOORFIELDS">MOORFIELDS</option>
        <option value="MOUNT VERNON CORE">MOUNT VERNON CORE</option>
        <option value="NORTH WANDSWORTH RENALS">NORTH WANDSWORTH RENALS</option>
        <option value="OXLEAS CORE">OXLEAS CORE</option>
        <option value="OXLEAS REC">OXLEAS REC</option>
        <option value="PRINCESS ROYAL HOSPITAL">PRINCESS ROYAL HOSPITAL</option>
        <option value="RICHMOND &amp; KINGSTON">RICHMOND &amp; KINGSTON</option>
        <option value="RICHMOND &amp; KINGSTON ECJ">RICHMOND &amp; KINGSTON ECJ</option>
        <option value="ROYAL NEURO">ROYAL NEURO</option>
        <option value="STAFFORDSHIRE - BETSI">STAFFORDSHIRE - BETSI</option>
        <option value="STAFFORDSHIRE - GREATER MANCHESTER">STAFFORDSHIRE - GREATER MANCHESTER</option>
        <option value="STAFFORDSHIRE - LANCASHIRE/ SOUTH CUMBRIA">STAFFORDSHIRE - LANCASHIRE/ SOUTH CUMBRIA</option>
        <option value="STG ADDITIONAL RESOURCES">STG ADDITIONAL RESOURCES</option>
        <option value="STG CORE">STG CORE</option>
        <option value="STG REC">STG REC</option>
        <option value="WEST MD STRETCHER CORE">WEST MD STRETCHER CORE</option>
        <option value="WEST MID CORE">WEST MID CORE</option>
        <option value="WEST MID MENTAL HEALTH">WEST MID MENTAL HEALTH</option>
        <option value="WEST MID OOH">WEST MID OOH</option>
        <option value="WEST MID SPEC 14">WEST MID SPEC 14</option>
        <option value="WEST MID STRETCHER OOH">WEST MID STRETCHER OOH</option>
        <option value="WHITTINGDON">WHITTINGDON</option>
        <option value="YORKSHIRE AMBULANCE">YORKSHIRE AMBULANCE</option>
        </select>

        @error('journey_time')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
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

      <!-- Wait & Return Checkbox -->
      <div class="mt-4">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="wait_return_checkbox" name="wait_return_enabled">
        <label class="form-check-label" for="wait_return_checkbox">
        Wait & Return
        </label>
      </div>
      </div>

      <!-- Wait & Return Fields (initially hidden) -->
      <div class="row mt-3 wait_return_fields" style="display: none;">
      <div class="col-md-6">
        <label for="destination_time" class="form-label">Destination Time</label>
        <input type="text" id="destination_time" name="destination_time" class="form-control" />
        @error('destination_time')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <div class="col-md-6">
        <label for="return_time" class="form-label">Return Time</label>
        <input type="text" id="return_time" name="return_time" class="form-control" />
        @error('return_time')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <input type="hidden" id="wait_return" name="wait_return" value="No" />
      </div>

      <!-- Job Description -->
      <div class="mt-4">
      <label for="description" class="form-label">Job Description</label>
      <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
      @error('description')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>

      <!-- removed duplicate address section -->

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

    $(document).ready(function () {
    // Pay type toggle
    $('#pay_type').change(function () {
      if ($(this).val() === 'shift') {
      $('.end_date_container, .end_time_container').hide();
      $('#end_date, #end_time').prop('required', false);
      // $('#journey_date_label').text('Journey Date');
      // $('#journey_time_label').text('Journey Time');
      $('#pay_label').text('Shift Pay');
      } else {
      $('.end_date_container, .end_time_container').show();
      $('#end_date, #end_time').prop('required', true);
      // $('#journey_date_label').text('Start Date');
      // $('#journey_time_label').text('Start Time');
      $('#pay_label').text('Hourly Pay');
      }
    });

    // Wait & Return toggle
    $('#wait_return_checkbox').change(function () {
      if (this.checked) {
      $('.wait_return_fields').show();
      $('#wait_return').val('Yes');
      } else {
      $('.wait_return_fields').hide();
      $('#wait_return').val('No');
      }
    });

    // Initialize based on initial values
    $('#pay_type').trigger('change');
    $('#wait_return_checkbox').trigger('change');
    });
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