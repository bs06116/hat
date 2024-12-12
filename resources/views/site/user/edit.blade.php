@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">
    <h5 class="card-header">Edit User</h5>
    <form method="POST" action="{{ route('users.update', $user->id) }}" class="card-body">
      @csrf
      @method('PUT')

      <!-- First Name and Last Name in one row -->
      <div class="row">
        <div class="col-md-6">
          <div class="mt-4">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control" required autofocus />
            @error('first_name')
              <div class="mt-2 text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mt-4">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control" required />
            @error('last_name')
              <div class="mt-2 text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <!-- Email Field -->
      <div class="mt-4">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required />
        @error('email')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Password and Confirm Password in one row -->
      <div class="row">
        <div class="col-md-6">
          <div class="mt-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" autocomplete="new-password" />
            @error('password')
              <div class="mt-2 text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="col-md-6">
          <div class="mt-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password" />
            @error('password_confirmation')
              <div class="mt-2 text-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <!-- Submit and Cancel -->
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-4">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
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
