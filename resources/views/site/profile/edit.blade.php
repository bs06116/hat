@extends('site.layouts.app')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">

            <div class="card mb-6">
                <!-- Account -->

            </div>
            <div class="card-body pt-4">
                <form id="formAccountSettings" method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    @method('patch') <!-- Use PUT method for updating the profile -->

                    <div class="row">
                        <!-- First Name -->
                        <div class="mb-4 col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input class="form-control @error('first_name') is-invalid @enderror" type="text"
                                id="first_name" name="first_name"
                                value="{{ old('firstName', auth()->user()->first_name) }}" autofocus />
                            @error('first_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="mb-4 col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input class="form-control @error('last_name') is-invalid @enderror" type="text"
                                name="last_name" id="last_name"
                                value="{{ old('last_name', auth()->user()->last_name) }}" />
                            @error('last_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                                name="email" value="{{ old('email', auth()->user()->email) }}" />
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>



                        <!-- Phone Number -->
                        <div class="mb-4 col-md-6">
                            <label class="form-label" for="	phone">Phone Number</label>
                            <div class="input-group input-group-merge">
                                <!-- <span class="input-group-text">US (+1)</span> -->
                                <input type="text" id="	phone" name="phone"
                                    class="form-control @error('	phone') is-invalid @enderror"
                                    value="{{ old('	phone', auth()->user()->phone) }}"
                                    placeholder="202 555 0111" />
                            </div>
                            @error('	phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Change Section -->
                        <div class="col-12">
                            <h5 class="mb-4">Change Password</h5>
                        </div>

                        <!-- Current Password -->
                        <div class="mb-4 col-md-6">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input class="form-control @error('current_password') is-invalid @enderror" type="password"
                                id="current_password" name="current_password" placeholder="Enter current password" />
                            @error('current_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-4 col-md-6">
                            <label for="password" class="form-label">New Password</label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                id="password" name="password" placeholder="Enter new password" />
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-4 col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input class="form-control" type="password" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm new password" />
                        </div>
                    </div>

                    <!-- Submit and Cancel buttons -->
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">Save changes</button>
                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                </form>

            </div>
            <!-- /Account -->
        </div>

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
