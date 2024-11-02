@extends('site.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Locations</h5>
      <a href="{{ route('locations.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i> Add New Location
      </a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
          <th>Location Name</th>
          <th>Address</th>
          <th>Action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($locations as $location)
          <tr>
          <td>{{ $location->name }}</td>
          <td>{{ $location->address }}</td>
          <td>
            <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-warning"><i class="ti ti-edit me-2"></i></a>
            <form action="{{ route('locations.destroy', $location->id) }}" method="POST"  onsubmit="return confirm('Are you sure you want to delete this location?');" style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger"><i class="ti ti-trash me-2"></i></button>
            </form>
          </td>
        </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">No Location found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
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

