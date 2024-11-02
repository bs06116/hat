@extends('site.layouts.app')
@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

  <!-- Content wrapper -->
  <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row g-6">
                <!-- Card Border Shadow -->
                <div class="col-lg-3 col-sm-6">
                  <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                          <span class="avatar-initial rounded bg-label-primary"
                            ><i class="ti ti-briefcase ti-28px"></i
                          ></span>
                        </div>
                        <h4 class="mb-0">{{$totalAvailableJobs}}</h4>
                      </div>
                      <p class="mb-1">Total Available Jobs</p>
                      <!-- <p class="mb-0">
                        <span class="text-heading fw-medium me-2">+18.2%</span>
                        <small class="text-muted">than last week</small>
                      </p> -->
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                  <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-2">
                        <div class="avatar me-4">
                          <span class="avatar-initial rounded bg-label-primary"
                            ><i class="ti ti-briefcase ti-28px"></i
                          ></span>
                        </div>
                        <h4 class="mb-0">{{$totalWonJobs}}</h4>
                      </div>
                      <p class="mb-1">Total Won Jobs</p>
                      <!-- <p class="mb-0">
                        <span class="text-heading fw-medium me-2">-8.7%</span>
                        <small class="text-muted">than last week</small>
                      </p> -->
                    </div>
                  </div>
                </div>
              
              
              </div>
            </div>
            <!-- / Content -->

          

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
@endsection