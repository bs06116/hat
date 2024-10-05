@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Sites</h5>
      <a href="{{ route('tenants.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i> Add New Site
      </a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Site Name</th>
            <th>Site Owner</th>
            <th>Domain</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($tenants as $tenant)
            <tr>
              <td>
                
                <i class="ti ti-building ti-md text-primary me-4"></i>
                <span class="fw-medium">{{ $tenant->name }}</span> <!-- Tenant Name -->
              </td>
              <td>
              {{$tenant->user->first_name.' '.$tenant->user->last_name }}  

          </td> 
            <!-- Client/Owner Name -->
              <td>
              {{$tenant->domain->domain}}
              </td>
              <td>
              @if ($tenant->user->status === \App\UserStatus::ACTIVE->value)
                      <span class="badge bg-label-primary">{{\App\UserStatus::ACTIVE}}</span>
                  @else
                      <span class="badge bg-label-secondary">{{\App\UserStatus::DEACTIVE}}</span>
                  @endif
              </td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical"></i>
                  </button>
                  <div class="dropdown-menu">
                  <form action="{{ route('tenants.toggleStatus', $tenant->user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-{{ $tenant->user->status == \App\UserStatus::DEACTIVE->value  ? 'success' : 'danger' }}">
                                {{ $tenant->user->status ==  \App\UserStatus::DEACTIVE->value  ? \App\UserStatus::ACTIVE : \App\UserStatus::DEACTIVE }}
                            </button>
                        </form>
                    <!-- <a class="dropdown-item" href="{{ route('tenants.edit', $tenant->id) }}"><i class="ti ti-pencil me-2"></i> Edit</a> -->
                    <form method="POST" action="{{ route('tenants.destroy', $tenant->id) }}" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button class="dropdown-item" type="submit"><i class="ti ti-trash me-2"></i> Delete</button>
                    </form>
                  </div>
                </div>
              </td>
            </tr>
            <div class="d-flex justify-content-center mt-4">
    {{ $tenants->links() }}
</div>
          @empty
            <tr>
              <td colspan="5" class="text-center">No tenants found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
