@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">
    <h5 class="card-header">Tenant Creation Form</h5>
    <form method="POST" action="{{ route('tenants.store') }}" class="card-body">
      @csrf
      <div class="mt-4">
        <label class="form-label">Site Name</label>
        <div class="input-group input-group-merge">
        <input type="text" id="site_name" name="site_name" value="{{ old('site_name')}}" class="form-control" required autofocus autocomplete="site_name" />
        </div>
        @error('site_name')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
    </div>
      <div class="mt-4">
        <label class="form-label" for="multicol-email">Domain</label>
        <div class="input-group input-group-merge">
        <input type="text"  class="form-control" name="domain_name" placeholder="domain" aria-label="domain" aria-describedby="multicol-email2">
        <span class="input-group-text" id="multicol-email2">@localhost.com</span>
        </div>
        @error('domain_name')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
    </div>
<!-- Name -->
      <div class="mt-4">
        <label for="name" class="form-label">Site Owner First Name</label>
        <input type="text" id="first_name" name="first_name" value="{{ old('first_name')}}" class="form-control" required autofocus autocomplete="first_name" />
        @error('first_name')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="mt-4">
        <label for="name" class="form-label">Site Owner Last Name</label>
        <input type="text" id="last_name" name="last_name" value="{{ old('last_name')}}" class="form-control" required autofocus autocomplete="last_name" />
        @error('last_name')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>
      <!-- Email -->
      <div class="mt-4">
        <label for="email" class="form-label">Site Owner Email</label>
        <input type="email" id="email" name="email" value="{{ old('email')}}" class="form-control" required autocomplete="username" />
        @error('email')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>
      <!-- Password -->
      <div class="mt-4">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password" />
        @error('password')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>
      
      <!-- Confirm Password -->
      <div class="mt-4">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password" />
        @error('password_confirmation')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>
      
      <!-- Submit and Cancel -->
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-4">Submit</button>
        <a href="{{ route('tenants.index') }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>

 @endsection

