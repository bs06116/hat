@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">
    <h5 class="card-header">Site Driver Creation Form</h5>
    <form method="POST" action="{{ route('drivers.store') }}" class="card-body">
      @csrf
     
      <!-- First Name and Last Name in one row -->
      <div class="row">
        <div class="col-md-6">
          <div class="mt-4">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control" required autofocus autocomplete="first_name" />
            @error('first_name')
              <div class="mt-2 text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mt-4">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-control" required autofocus autocomplete="last_name" />
            @error('last_name')
              <div class="mt-2 text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <!-- Email -->
      <div class="mt-4">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required autocomplete="username" />
        @error('email')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>
     
      <!-- Password and Confirm Password in one row -->
      <div class="row">
        <div class="col-md-6">
          <div class="mt-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password" />
            @error('password')
              <div class="mt-2 text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mt-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password" />
            @error('password_confirmation')
              <div class="mt-2 text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <!-- Address -->
      <div class="mt-4">
        <label for="address" class="form-label">Address</label>
        <textarea id="address" name="address" class="form-control">{{ old('address') }}</textarea>
        @error('address')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Department -->
      <div class="mt-4">
        <label for="department" class="form-label">Department</label>
        @foreach($departments as $department)
          <div>
            <input type="checkbox" name="departments[]" value="{{ $department->id }}" {{ in_array($department->id, old('departments', [])) ? 'checked' : '' }}>
            <label>{{ $department->name }}</label>
          </div>
        @endforeach
        @error('departments')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Submit and Cancel -->
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-4">Submit</button>
        <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Cancel</a>
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
@endpush
