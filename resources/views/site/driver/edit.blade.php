@extends('site.layouts.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
    <h5 class="card-header">Edit Driver</h5>
    <form method="POST" action="{{ route('drivers.update', $driver->id) }}" class="card-body">
      @csrf
      @method('PUT')

      <!-- First Name and Last Name in one row -->
      <div class="row">
      <div class="col-md-6">
        <div class="mt-4">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $driver->first_name) }}"
          class="form-control" required autofocus />
        @error('first_name')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
        </div>
      </div>
      <div class="col-md-6">
        <div class="mt-4">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $driver->last_name) }}"
          class="form-control" required />
        @error('last_name')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
        </div>
      </div>
      </div>

      <!-- Email -->
      <div class="mt-4">
      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" name="email" value="{{ old('email', $driver->email) }}" class="form-control"
        required />
      @error('email')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>

      <!-- Password (optional) -->
      <div class="mt-4">
      <label for="password" class="form-label">Password (Leave blank to keep the current password)</label>
      <input type="password" id="password" name="password" class="form-control" autocomplete="new-password" />
      @error('password')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>

      <!-- Confirm Password -->
      <div class="mt-4">
      <label for="password_confirmation" class="form-label">Confirm Password</label>
      <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
        autocomplete="new-password" />
      @error('password_confirmation')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>

      <div class="row">
      <div class="col-md-6">
        <div class="mt-4">
        <label for="driver_number" class="form-label">Driver Number</label>
        <input type="text" id="driver_number" name="driver_number"
          value="{{ old('email', $driver->driver_number) }}" class="form-control" required autofocus
          autocomplete="driver_number" />
        @error('driver_number')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
        </div>
      </div>
      <div class="col-md-6">
        <div class="mt-4">
        <label for="location" class="form-label">Vehicle Type</label>
        <select name="vehicle_type" id="vehicle_type" class="form-control" required>
          <option value="">Vehicle Type</option>
          <option value="5seater" {{ old('vehicle_type', $driver->vehicle_type) == '5seater' ? 'selected' : '' }}>5
          seater</option>
          <option value="7seater" {{ old('vehicle_type', $driver->vehicle_type) == '7seater' ? 'selected' : '' }}>7
          seater</option>
          <option value="9seater" {{ old('vehicle_type', $driver->vehicle_type) == '9seater' ? 'selected' : '' }}>9
          seater</option>
          <option value="Iw" {{ old('vehicle_type', $driver->vehicle_type) == 'Iw' ? 'selected' : '' }}>1 WAV</option>
        </select>
        @error('vehicle_type')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
        </div>
      </div>
      <!-- <div class="col-md-6">
      <div class="mt-4">
      <label for="rating" class="form-label">Rating</label>
      <select name="rating" id="rating" class="form-control">
      <option value="1" {{ $driver->rating == 1?'selected':'' }}>1</option>
      <option value="2" {{ $driver->rating == 2?'selected':'' }}>2</option>
      <option value="3" {{ $driver->rating == 3?'selected':'' }}>3</option>
      <option value="4" {{ $driver->rating == 4?'selected':'' }}>4</option>
      <option value="5" {{ $driver->rating == 5?'selected':'' }}>5</option>

      </select>
      @error('rating')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      </div> -->
      </div>
      <!-- Notes -->
      <div class="mt-4">
      <label for="note" class="form-label">Note</label>
      <textarea id="note" name="note" class="form-control">{{ old('note', $driver->note) }}</textarea>
      @error('note')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <!-- Address -->
      <div class="mt-4">
      <label for="address" class="form-label">Address</label>
      <textarea id="address" name="address" class="form-control">{{ old('address', $driver->address) }}</textarea>
      @error('address')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>
      <!-- Departments (multi-select) -->
      <div class="mt-4">
      <label for="departments" class="form-label">Departments</label>
      @foreach($departments as $department)
      <div class="form-check">
      <input type="checkbox" class="form-check-input" id="department_{{ $department->id }}" name="departments[]"
      value="{{ $department->id }}" {{ $driver->departments->contains($department->id) ? 'checked' : '' }}>
      <label class="form-check-label" for="department_{{ $department->id }}">
      {{ $department->name }}
      </label>
      </div>
    @endforeach
      @error('departments')
      <div class="mt-2 text-danger">{{ $message }}</div>
    @enderror
      </div>

      <!-- Submit and Cancel -->
      <div class="pt-4">
      <button type="submit" class="btn btn-primary me-4">Update</button>
      <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
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