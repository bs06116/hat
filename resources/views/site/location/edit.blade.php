@extends('site.layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">
    <h5 class="card-header">Edit Location</h5>
    <form method="POST" action="{{ route('locations.update', $location->id) }}" class="card-body">
      @csrf
      @method('PUT')

      <!-- First Name -->
      <div class="mt-4">
        <label for="name" class="form-label">Location Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $location->name) }}" class="form-control" required autofocus />
        @error('name')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Last Name -->
      <div class="mt-4">
        <label for="address" class="form-label">Address</label>
        <textarea type="text" id="address" name="address" class="form-control">{{ $location->address }}</textarea>
      </div>
    


 <!-- Submit and Cancel -->
 <div class="pt-4">
        <button type="submit" class="btn btn-primary me-4">Update</button>
        <a href="{{ route('locations.index') }}" class="btn btn-secondary">Cancel</a>
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
