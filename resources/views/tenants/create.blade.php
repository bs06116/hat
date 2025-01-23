@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">
    <h5 class="card-header">Site Creation Form</h5>
    <form method="POST" action="{{ route('tenants.store') }}" class="card-body">
      @csrf
      <!-- Site Name and Domain (two fields in one row) -->
      <div class="row">
        <div class="col-md-6 mt-4">
          <label class="form-label" for="site_name">Site Name</label>
          <div class="input-group input-group-merge">
          <input type="text" id="site_name" name="site_name" value="{{ old('site_name') }}" class="form-control" required autofocus autocomplete="site_name" style="text-transform: capitalize;" />
          </div>
          @error('site_name')
            <div class="mt-2 text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6 mt-4">
          <label class="form-label" for="domain_name">Domain</label>
          <div class="input-group input-group-merge">
            <input type="text" class="form-control" name="domain_name" value="{{ old('domain_name') }}" placeholder="Enter domain" aria-label="domain" aria-describedby="multicol-email2">
            <span class="input-group-text" id="multicol-email2">.{{ config('app.domain') }}</span>
          </div>
          @error('domain_name')
            <div class="mt-2 text-danger">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <!-- Site Admin First Name and Last Name (two fields in one row) -->
      <div class="row">
        <div class="col-md-6 mt-4">
          <label for="first_name" class="form-label">Site Admin First Name</label>
          <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control" required autofocus autocomplete="first_name" />
          @error('first_name')
            <div class="mt-2 text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6 mt-4">
          <label for="last_name" class="form-label">Site Admin Last Name</label>
          <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-control" required autofocus autocomplete="last_name" />
          @error('last_name')
            <div class="mt-2 text-danger">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Site Admin Email and Password (two fields in one row) -->
      <div class="row">
        <div class="col-md-6 mt-4">
          <label for="email" class="form-label">Site Admin Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required autocomplete="username" />
          @error('email')
            <div class="mt-2 text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6 mt-4">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password" />
          @error('password')
            <div class="mt-2 text-danger">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Confirm Password (single field in this row) -->
      <div class="row">
        <div class="col-md-6 mt-4">
          <label for="password_confirmation" class="form-label">Confirm Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password" />
          @error('password_confirmation')
            <div class="mt-2 text-danger">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Submit and Cancel Buttons -->
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-4">Submit</button>
        <a href="{{ route('tenants.index') }}" class="btn btn-secondary">Cancel</a>
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
