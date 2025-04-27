@extends('site.layouts.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
    <h5 class="card-header">Edit Job</h5>
    <form method="POST" action="{{ route('jobs.update', $job->id) }}" class="card-body">
      @csrf
      @method('PUT')
      <div class="row">
      <!-- Passenger Name -->
      <div class="col-md-6 mt-4">
        <label for="passenger_name" class="form-label">Passenger Name</label>
        <input type="text" id="passenger_name" name="passenger_name"
        value="{{ old('hourly_pay', $job->passenger_name) }}" class="form-control" />

        @error('passenger_name')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>

      <!-- passenger_contact_number -->
      <div class="col-md-6 mt-4">
        <label for="passenger_contact_number" class="form-label">Passenger Contact Number</label>
        <input type="text" id="passenger_contact_number" name="passenger_contact_number"
        value="{{ old('hourly_pay', $job->passenger_contact_number) }}" class="form-control" />
        @error('passenger_contact_number')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      </div>
      <div class="row">
      <!-- Department Selection -->
      <div class="col-md-6 mt-4">
        <label for="department" class="form-label">Departments</label>
        <select name="department_ids[]" id="department" class="form-control" required>
        @foreach($departments as $department)
      <option value="{{ $department->id }}" {{ in_array($department->id, old('department_ids', $job->departments->pluck('id')->toArray())) ? 'selected' : '' }}>
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
        <label for="title" class="form-label">Job Title</label>
        <select id="job_title" name="title" class="form-control" required>
        <option value="">Select a Job Title</option>
        </select>
      </div>
      </div>

      <div class="row">
      <!-- Location Selection -->
      <div class="col-md-6 mt-4">
        <div class="row">
        <div class="col-md-6">
          <label for="location" class="form-label">Location</label>
          <select name="location_id" id="location" class="form-control" required>
          <option value="">Select a Location</option>
          @foreach($locations as $location)
        <option value="{{ $location->id }}" {{ old('location_id', $job->location_id) == $location->id ? 'selected' : '' }}>
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
          <option value="5seater" {{ old('vehicle_type', $job->vehicle_type) == '5seater' ? 'selected' : '' }}>5
            seater</option>
          <option value="7seater" {{ old('vehicle_type', $job->vehicle_type) == '7seater' ? 'selected' : '' }}>7
            seater</option>
          <option value="9seater" {{ old('vehicle_type', $job->vehicle_type) == '9seater' ? 'selected' : '' }}>9
            seater</option>
          <option value="Iw" {{ old('vehicle_type', $job->vehicle_type) == 'Iw' ? 'selected' : '' }}>1 WAV</option>
          </select>
          @error('vehicle_type')
        <div class="mt-2 text-danger">{{ $message }}</div>
      @enderror
        </div>
        </div>
      </div>
      <!-- Hourly Pay -->
      <div class="col-md-6 mt-4">
        <div class="row">

        <div class="col-md-6">
          <label for="pay_type" class="form-label">Pay Type</label>
          <select name="pay_type" id="pay_type" class="form-control" required>
          <option value="">Select Pay Type</option>
          <option value="hourly" {{ old('pay_type', $job->pay_type) == 'hourly' ? 'selected' : '' }}>Hourly</option>
          <option value="shift" {{ old('pay_type', $job->pay_type) == 'shift' ? 'selected' : '' }}>Per Shift
          </option>
          </select>
          @error('pay_type')
        <div class="mt-2 text-danger">{{ $message }}</div>
      @enderror
        </div>
        <div class="col-md-6">
          <label for="hourly_pay" class="form-label"><span id="pay_label">Pay</span> (&pound;)</label>
          <input type="number" id="hourly_pay" name="hourly_pay" value="{{ old('hourly_pay', $job->hourly_pay) }}"
          class="form-control" step="0.01" required />
          @error('hourly_pay')
        <div class="mt-2 text-danger">{{ $message }}</div>
      @enderror

        </div>
        </div>
      </div>

      </div>

      <div class="row">
      <!-- Start Date -->
      <div class="col-md-6 mt-4">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="date" id="start_date" name="start_date"
        value="{{ old('start_date', $job->start_date ? $job->start_date->toDateString() : '') }}"
        class="form-control" required />
        @error('start_date')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <!-- End Date -->
      <div class="col-md-6 mt-4 end_date_container"
        style="display: {{ old('pay_type', $job->pay_type) == 'shift' ? 'none' : 'block' }}">
        <label for="end_date" class="form-label">End Date</label>
        <input type="date" id="end_date" name="end_date"
        value="{{ old('end_date', $job->end_date ? $job->end_date->toDateString() : '') }}" class="form-control"
        required />
        @error('end_date')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>


      </div>

      <div class="row">
      <!-- Start Time -->
      <div class="col-md-6 mt-4">
        <label for="start_time" class="form-label">Start Time</label>
        <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $job->start_time) }}"
        class="form-control" required />
        @error('start_time')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <!-- End Time -->
      <div class="col-md-6 mt-4 end_time_container"
        style="display: {{ old('pay_type', $job->pay_type) == 'shift' ? 'none' : 'block' }}">
        <label for="end_time" class="form-label">End Time</label>
        <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $job->end_time) }}"
        class="form-control" required />
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
        <option value="City of London Corporation" {{ old('local_authorities', $job->local_authorities) == 'City of London Corporation' ? 'selected' : '' }}>City of London Corporation</option>
        <option value="City of Westminster" {{ old('local_authorities', $job->local_authorities) == 'City of Westminster' ? 'selected' : '' }}>City of Westminster</option>
        <option value="LB Barking and Dagenham" {{ old('local_authorities', $job->local_authorities) == 'LB Barking and Dagenham' ? 'selected' : '' }}>LB Barking and Dagenham</option>
        <option value="LB Barnet" {{ old('local_authorities', $job->local_authorities) == 'LB Barnet' ? 'selected' : '' }}>LB Barnet</option>
        <option value="LB Bexley" {{ old('local_authorities', $job->local_authorities) == 'LB Bexley' ? 'selected' : '' }}>LB Bexley</option>
        <option value="LB Brent" {{ old('local_authorities', $job->local_authorities) == 'LB Brent' ? 'selected' : '' }}>LB Brent</option>
        <option value="LB Bromley" {{ old('local_authorities', $job->local_authorities) == 'LB Bromley' ? 'selected' : '' }}>LB Bromley</option>
        <option value="LB Camden" {{ old('local_authorities', $job->local_authorities) == 'LB Camden' ? 'selected' : '' }}>LB Camden</option>
        <option value="LB Croydon" {{ old('local_authorities', $job->local_authorities) == 'LB Croydon' ? 'selected' : '' }}>LB Croydon</option>
        <option value="LB Ealing" {{ old('local_authorities', $job->local_authorities) == 'LB Ealing' ? 'selected' : '' }}>LB Ealing</option>
        <option value="LB Enfield" {{ old('local_authorities', $job->local_authorities) == 'LB Enfield' ? 'selected' : '' }}>LB Enfield</option>
        <option value="LB Hackney" {{ old('local_authorities', $job->local_authorities) == 'LB Hackney' ? 'selected' : '' }}>LB Hackney</option>
        <option value="LB Hammersmith &amp; Fulham" {{ old('local_authorities', $job->local_authorities) == 'LB Hammersmith & Fulham' ? 'selected' : '' }}>LB Hammersmith &amp; Fulham</option>
        <option value="LB Haringey" {{ old('local_authorities', $job->local_authorities) == 'LB Haringey' ? 'selected' : '' }}>LB Haringey</option>
        <option value="LB Harrow" {{ old('local_authorities', $job->local_authorities) == 'LB Harrow' ? 'selected' : '' }}>LB Harrow</option>
        <option value="LB Havering" {{ old('local_authorities', $job->local_authorities) == 'LB Havering' ? 'selected' : '' }}>LB Havering</option>
        <option value="LB Hillingdon" {{ old('local_authorities', $job->local_authorities) == 'LB Hillingdon' ? 'selected' : '' }}>LB Hillingdon</option>
        <option value="LB Hounslow" {{ old('local_authorities', $job->local_authorities) == 'LB Hounslow' ? 'selected' : '' }}>LB Hounslow</option>
        <option value="LB Islington" {{ old('local_authorities', $job->local_authorities) == 'LB Islington' ? 'selected' : '' }}>LB Islington</option>
        <option value="LB Lambeth" {{ old('local_authorities', $job->local_authorities) == 'LB Lambeth' ? 'selected' : '' }}>LB Lambeth</option>
        <option value="LB Lewisham" {{ old('local_authorities', $job->local_authorities) == 'LB Lewisham' ? 'selected' : '' }}>LB Lewisham</option>
        <option value="LB Merton" {{ old('local_authorities', $job->local_authorities) == 'LB Merton' ? 'selected' : '' }}>LB Merton</option>
        <option value="LB Newham" {{ old('local_authorities', $job->local_authorities) == 'LB Newham' ? 'selected' : '' }}>LB Newham</option>
        <option value="LB Redbridge" {{ old('local_authorities', $job->local_authorities) == 'LB Redbridge' ? 'selected' : '' }}>LB Redbridge</option>
        <option value="LB Richmond Upon Thames" {{ old('local_authorities', $job->local_authorities) == 'LB Richmond Upon Thames' ? 'selected' : '' }}>LB Richmond Upon Thames</option>
        <option value="LB Southwark" {{ old('local_authorities', $job->local_authorities) == 'LB Southwark' ? 'selected' : '' }}>LB Southwark</option>
        <option value="LB Sutton" {{ old('local_authorities', $job->local_authorities) == 'LB Sutton' ? 'selected' : '' }}>LB Sutton</option>
        <option value="LB Tower Hamlets" {{ old('local_authorities', $job->local_authorities) == 'LB Tower Hamlets' ? 'selected' : '' }}>LB Tower Hamlets</option>
        <option value="LB Waltham Forest" {{ old('local_authorities', $job->local_authorities) == 'LB Waltham Forest' ? 'selected' : '' }}>LB Waltham Forest</option>
        <option value="LB Wandsworth" {{ old('local_authorities', $job->local_authorities) == 'LB Wandsworth' ? 'selected' : '' }}>LB Wandsworth</option>
        <option value="RB Greenwich" {{ old('local_authorities', $job->local_authorities) == 'RB Greenwich' ? 'selected' : '' }}>RB Greenwich</option>
        <option value="RB Kensington &amp; Chelsea" {{ old('local_authorities', $job->local_authorities) == 'RB Kensington & Chelsea' ? 'selected' : '' }}>RB Kensington &amp; Chelsea</option>
        <option value="RB Kingston Upon Thames" {{ old('local_authorities', $job->local_authorities) == 'RB Kingston Upon Thames' ? 'selected' : '' }}>RB Kingston Upon Thames</option>
        </select>

        @error('local_authorities')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>

      <div class="col-md-6 mt-4">
        <label for="trust" class="form-label">Trusty</label>
        <select name="trust" id="trust" class="form-control">
        <option value="BROMLEY HEALTHCARE" {{ old('trust', $job->trust) == 'BROMLEY HEALTHCARE' ? 'selected' : '' }}>
          BROMLEY HEALTHCARE</option>
        <option value="CHELSEA CORE" {{ old('trust', $job->trust) == 'CHELSEA CORE' ? 'selected' : '' }}>CHELSEA CORE
        </option>
        <option value="CHELSEA COVID SUPPORT" {{ old('trust', $job->trust) == 'CHELSEA COVID SUPPORT' ? 'selected' : '' }}>CHELSEA COVID SUPPORT</option>
        <option value="CHELSEA REC" {{ old('trust', $job->trust) == 'CHELSEA REC' ? 'selected' : '' }}>CHELSEA REC
        </option>
        <option value="CLCH TAXIS CLCH01-CLCH11" {{ old('trust', $job->trust) == 'CLCH TAXIS CLCH01-CLCH11' ? 'selected' : '' }}>CLCH TAXIS CLCH01-CLCH11</option>
        <option value="CNWL (Ealing)" {{ old('trust', $job->trust) == 'CNWL (Ealing)' ? 'selected' : '' }}>CNWL
          (Ealing)</option>
        <option value="CNWL QTS" {{ old('trust', $job->trust) == 'CNWL QTS' ? 'selected' : '' }}>CNWL QTS</option>
        <option value="CNWL SCHOOL VAC" {{ old('trust', $job->trust) == 'CNWL SCHOOL VAC' ? 'selected' : '' }}>CNWL
          SCHOOL VAC</option>
        <option value="CNWL STP09" {{ old('trust', $job->trust) == 'CNWL STP09' ? 'selected' : '' }}>CNWL STP09
        </option>
        <option value="CNWL02 MENTAL HEALTH" {{ old('trust', $job->trust) == 'CNWL02 MENTAL HEALTH' ? 'selected' : '' }}>CNWL02 MENTAL HEALTH</option>
        <option value="COLLIERS WOOD RENALS" {{ old('trust', $job->trust) == 'COLLIERS WOOD RENALS' ? 'selected' : '' }}>COLLIERS WOOD RENALS</option>
        <option value="CROYDON CORE" {{ old('trust', $job->trust) == 'CROYDON CORE' ? 'selected' : '' }}>CROYDON CORE
        </option>
        <option value="CROYDON TAXI / ANTI COAG" {{ old('trust', $job->trust) == 'CROYDON TAXI / ANTI COAG' ? 'selected' : '' }}>CROYDON TAXI / ANTI COAG</option>
        <option value="CROYDON VITA" {{ old('trust', $job->trust) == 'CROYDON VITA' ? 'selected' : '' }}>CROYDON VITA
        </option>
        <option value="DARENT VALLEY" {{ old('trust', $job->trust) == 'DARENT VALLEY' ? 'selected' : '' }}>DARENT
          VALLEY</option>
        <option value="GOSH ADDITIONAL ROLLING COST" {{ old('trust', $job->trust) == 'GOSH ADDITIONAL ROLLING COST' ? 'selected' : '' }}>GOSH ADDITIONAL ROLLING COST</option>
        <option value="GOSH CORE" {{ old('trust', $job->trust) == 'GOSH CORE' ? 'selected' : '' }}>GOSH CORE</option>
        <option value="GOSH PTS" {{ old('trust', $job->trust) == 'GOSH PTS' ? 'selected' : '' }}>GOSH PTS</option>
        <option value="GOSH RENALS" {{ old('trust', $job->trust) == 'GOSH RENALS' ? 'selected' : '' }}>GOSH RENALS
        </option>
        <option value="GOSH TAXI" {{ old('trust', $job->trust) == 'GOSH TAXI' ? 'selected' : '' }}>GOSH TAXI</option>
        <option value="HAMMERSMITH AND FULHAM &amp; KENSINGTON &amp; CHELSEA" {{ old('trust', $job->trust) == 'HAMMERSMITH AND FULHAM & KENSINGTON & CHELSEA' ? 'selected' : '' }}>HAMMERSMITH AND FULHAM
          &amp; KENSINGTON &amp; CHELSEA</option>
        <option value="HILLCADV" {{ old('trust', $job->trust) == 'HILLCADV' ? 'selected' : '' }}>HILLCADV</option>
        <option value="HILLINGDON CCG O/A" {{ old('trust', $job->trust) == 'HILLINGDON CCG O/A' ? 'selected' : '' }}>
          HILLINGDON CCG O/A</option>
        <option value="HILLINGDON CORE" {{ old('trust', $job->trust) == 'HILLINGDON CORE' ? 'selected' : '' }}>
          HILLINGDON CORE</option>
        <option value="HILLINGDON MENTAL HEALTH" {{ old('trust', $job->trust) == 'HILLINGDON MENTAL HEALTH' ? 'selected' : '' }}>HILLINGDON MENTAL HEALTH</option>
        <option value="IMPERIAL" {{ old('trust', $job->trust) == 'IMPERIAL' ? 'selected' : '' }}>IMPERIAL</option>
        <option value="KINGS COLLEGE" {{ old('trust', $job->trust) == 'KINGS COLLEGE' ? 'selected' : '' }}>KINGS
          COLLEGE</option>
        <option value="KINGSTON CORE" {{ old('trust', $job->trust) == 'KINGSTON CORE' ? 'selected' : '' }}>KINGSTON
          CORE</option>
        <option value="KINGSTON OVERACTIVITY" {{ old('trust', $job->trust) == 'KINGSTON OVERACTIVITY' ? 'selected' : '' }}>KINGSTON OVERACTIVITY</option>
        <option value="L&amp;G CORE" {{ old('trust', $job->trust) == 'L&G CORE' ? 'selected' : '' }}>L&amp;G CORE
        </option>
        <option value="L&amp;G TAXI / TT's" {{ old('trust', $job->trust) == "L&G TAXI / TT's" ? 'selected' : '' }}>
          L&amp;G TAXI / TT's</option>
        <option value="LAS" {{ old('trust', $job->trust) == 'LAS' ? 'selected' : '' }}>LAS</option>
        <option value="MANCHESTER" {{ old('trust', $job->trust) == 'MANCHESTER' ? 'selected' : '' }}>MANCHESTER
        </option>
        <option value="MOORFIELDS" {{ old('trust', $job->trust) == 'MOORFIELDS' ? 'selected' : '' }}>MOORFIELDS
        </option>
        <option value="MOUNT VERNON CORE" {{ old('trust', $job->trust) == 'MOUNT VERNON CORE' ? 'selected' : '' }}>
          MOUNT VERNON CORE</option>
        <option value="NORTH WANDSWORTH RENALS" {{ old('trust', $job->trust) == 'NORTH WANDSWORTH RENALS' ? 'selected' : '' }}>NORTH WANDSWORTH RENALS</option>
        <option value="OXLEAS CORE" {{ old('trust', $job->trust) == 'OXLEAS CORE' ? 'selected' : '' }}>OXLEAS CORE
        </option>
        <option value="OXLEAS REC" {{ old('trust', $job->trust) == 'OXLEAS REC' ? 'selected' : '' }}>OXLEAS REC
        </option>
        <option value="PRINCESS ROYAL HOSPITAL" {{ old('trust', $job->trust) == 'PRINCESS ROYAL HOSPITAL' ? 'selected' : '' }}>PRINCESS ROYAL HOSPITAL</option>
        <option value="RICHMOND &amp; KINGSTON" {{ old('trust', $job->trust) == 'RICHMOND & KINGSTON' ? 'selected' : '' }}>RICHMOND &amp; KINGSTON</option>
        <option value="RICHMOND &amp; KINGSTON ECJ" {{ old('trust', $job->trust) == 'RICHMOND & KINGSTON ECJ' ? 'selected' : '' }}>RICHMOND &amp; KINGSTON ECJ</option>
        <option value="ROYAL NEURO" {{ old('trust', $job->trust) == 'ROYAL NEURO' ? 'selected' : '' }}>ROYAL NEURO
        </option>
        <option value="STAFFORDSHIRE - BETSI" {{ old('trust', $job->trust) == 'STAFFORDSHIRE - BETSI' ? 'selected' : '' }}>STAFFORDSHIRE - BETSI</option>
        <option value="STAFFORDSHIRE - GREATER MANCHESTER" {{ old('trust', $job->trust) == 'STAFFORDSHIRE - GREATER MANCHESTER' ? 'selected' : '' }}>STAFFORDSHIRE - GREATER MANCHESTER</option>
        <option value="STAFFORDSHIRE - LANCASHIRE/ SOUTH CUMBRIA" {{ old('trust', $job->trust) == 'STAFFORDSHIRE - LANCASHIRE/ SOUTH CUMBRIA' ? 'selected' : '' }}>STAFFORDSHIRE - LANCASHIRE/ SOUTH CUMBRIA</option>
        <option value="STG ADDITIONAL RESOURCES" {{ old('trust', $job->trust) == 'STG ADDITIONAL RESOURCES' ? 'selected' : '' }}>STG ADDITIONAL RESOURCES</option>
        <option value="STG CORE" {{ old('trust', $job->trust) == 'STG CORE' ? 'selected' : '' }}>STG CORE</option>
        <option value="STG REC" {{ old('trust', $job->trust) == 'STG REC' ? 'selected' : '' }}>STG REC</option>
        <option value="WEST MD STRETCHER CORE" {{ old('trust', $job->trust) == 'WEST MD STRETCHER CORE' ? 'selected' : '' }}>WEST MD STRETCHER CORE</option>
        <option value="WEST MID CORE" {{ old('trust', $job->trust) == 'WEST MID CORE' ? 'selected' : '' }}>WEST MID
          CORE</option>
        <option value="WEST MID MENTAL HEALTH" {{ old('trust', $job->trust) == 'WEST MID MENTAL HEALTH' ? 'selected' : '' }}>WEST MID MENTAL HEALTH</option>
        <option value="WEST MID OOH" {{ old('trust', $job->trust) == 'WEST MID OOH' ? 'selected' : '' }}>WEST MID OOH
        </option>
        <option value="WEST MID SPEC 14" {{ old('trust', $job->trust) == 'WEST MID SPEC 14' ? 'selected' : '' }}>WEST
          MID SPEC 14</option>
        <option value="WEST MID STRETCHER OOH" {{ old('trust', $job->trust) == 'WEST MID STRETCHER OOH' ? 'selected' : '' }}>WEST MID STRETCHER OOH</option>
        <option value="WHITTINGDON" {{ old('trust', $job->trust) == 'WHITTINGDON' ? 'selected' : '' }}>WHITTINGDON
        </option>
        <option value="YORKSHIRE AMBULANCE" {{ old('trust', $job->trust) == 'YORKSHIRE AMBULANCE' ? 'selected' : '' }}>YORKSHIRE AMBULANCE</ </div>
          <div class="row mt-4">
          <div class="col-md-4">
            <label for="wait_return" class="form-label">Wait & Return</label>
            <input type="text" id="wait_return" name="wait_return"
            value="{{ old('wait_return', $job->wait_return) }}" class="form-control" />
            @error('wait_return')
        <div class="mt-2 text-danger">{{ $message }}</div>
      @enderror
          </div>
          <div class="col-md-4">
            <label for="return_time" class="form-label">Return Time</label>
            <input type="text" id="return_time" name="return_time"
            value="{{ old('return_time', $job->return_time) }}" class="form-control" />
            @error('return_time')
        <div class="mt-2 text-danger">{{ $message }}</div>
      @enderror
          </div>
          <div class="col-md-4">

            <label for="destination_time" class="form-label">Destination Time</label>
            <input type="text" id="destination_time" name="destination_time"
            value="{{ old('destination_time', $job->destination_time) }}" class="form-control" />
            @error('destination_time')
        <div class="mt-2 text-danger">{{ $message }}</div>
      @enderror
          </div>
          </div>

          <!-- Job Description -->
          <div class="mt-4">
          <label for="description" class="form-label">Job Description</label>
          <textarea id="description" name="description" class="form-control"
            rows="4">{{ old('description', $job->description) }}</textarea>
          @error('description')
        <div class="mt-2 text-danger">{{ $message }}</div>
      @enderror
          </div>

          <!-- Pickup and Drop Address -->
          <div class="mt-4">
          <label for="addresses" class="form-label">Addresses</label>
          @foreach(old('addresses', $addresses ?? []) as $index => $address)
        <div class="input-group mb-3">
        <input type="text" name="addresses[]" class="form-control" placeholder="Address"
        value="{{ $address }}" required />
        @if($index > 0)
      <button type="button" class="btn btn-danger remove-address">Remove</button>
    @endif
        </div>
      @endforeach
          </div>

          <div id="addresses"></div>
          <div class="input-group mb-3">
          <button type="button" class="btn btn-primary add-address">Add</button>
          </div>



          <!-- add input checkbo box for round trip -->
          <!-- <div  class="mt-4">
      <label for="round_trip" class="form-label"> is Round Trip?</label>
      <input type="checkbox"  name="round_trip" {{ old('round_trip', $job->round_trip) ? 'checked' : '' }}>

      </div> -->
          <!-- Submit and Cancel -->
          <div class="pt-4">
          <button type="submit" class="btn btn-primary me-4">Update</button>
          <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Cancel</a>
          </div>
    </form>
    </div>
  </div>
@endsection
@push('scripts')
  <script>
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

    // Add new address field at the bottom
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
    // Trigger the department change event to load job titles
    $('#department').trigger('change');
    });

    $('#department').change(function () {
    var departmentId = $(this).val();
    if (!departmentId) {
      departmentId = @json($job->departments->pluck('id')->toArray()); // Fallback for multi-department jobs
    }

    if (departmentId) {
      $.ajax({
      url: "{{ route('get.job.title', ':id') }}".replace(':id', departmentId),
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        var selectedJobTitle = @json($job->title); // Selected job title for the edit form

        $('#job_title').empty().append('<option value="">Select a Job Title</option>');
        $.each(data, function (key, value) {
        var selected = (selectedJobTitle == key) ? 'selected' : '';  // Ensure the correct job title is selected
        $('#job_title').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
        });
      }
      });
    } else {
      $('#job_title').empty().append('<option value="">Select a Job Title</option>');
    }
    });
  </script>
@endpush