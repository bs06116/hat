<!doctype html>
<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{asset('')}}"
  data-template="vertical-menu-template"
  data-style="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
      <meta name="csrf-token" content="{{ csrf_token() }}">


    <meta name="description" content="" />
    <title>{{ config('app.name', 'HATS') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('img/avatars/logo.png')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/fonts/tabler-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->

    <link rel="stylesheet" href="{{asset('vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />

    <link rel="stylesheet" href="{{asset('css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('vendor/libs/node-waves/node-waves.css')}}" />

    <link rel="stylesheet" href="{{asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/libs/apex-charts/apex-charts.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/libs/swiper/swiper.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}" />
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{asset('vendor/css/pages/cards-advance.css')}}"/>

    <!-- Helpers -->
    <script src="{{asset('vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{asset('vendor/js/template-customizer.js')}}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('js/config.js')}}"></script>
    <style type="text/css">
   /* Success Notification */
   #toast-container .toast-success {
        background-color: #28a745 !important;  /* Green */
        color: white !important;
        border-color: #28a745 !important; /* Optional: Add border for clarity */
    }

    /* Error Notification */
    #toast-container .toast-error {
        background-color: #dc3545 !important;  /* Red */
        color: white !important;
    }

    /* Info Notification */
    #toast-container .toast-info {
        background-color: #17a2b8 !important;  /* Blue */
        color: white !important;
    }

    /* Warning Notification */
    #toast-container .toast-warning {
        background-color: #ffc107 !important;  /* Yellow */
        color: black !important;
    }
  
    </style>
  </head>
  <body>

   <!-- Layout wrapper -->
   <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        @if (Auth::user()->hasRole(\App\RolesEnum::SITEDRIVER->value))
           @include( 'site.left_menu_driver')
          @else
          @include('site.left_menu')
        @endif
        <!-- / Menu -->
        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          @include('site.top_header')
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            @yield('content')

            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="text-body">
                    ©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , made with ❤️ by <a href="https://aethon.digital/" target="_blank" class="footer-link">Aethon.digital</a>
                    </div>
            
                  </div>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->
  

  <script src="{{asset('vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('vendor/libs/node-waves/node-waves.js')}}"></script>
    <script src="{{asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('vendor/libs/hammer/hammer.js')}}"></script>
    <script src="{{asset('vendor/libs/i18n/i18n.js')}}"></script>
    <script src="{{asset('vendor/libs/typeahead-js/typeahead.js')}}"></script>
    <script src="{{asset('vendor/js/menu.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('vendor/libs/apex-charts/apexcharts.js')}}"></script>
    <script src="{{asset('vendor/libs/swiper/swiper.js')}}"></script>
    <script src="{{asset('vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('js/dashboards-analytics.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')

<!-- Toastr JS -->
    </body>

</html>

<script>
   $(document).ready(function () {
    function loadNotifications() {
        $.ajax({
            url: "{{ route('notifications.fetch') }}",
            type: "GET",
            dataType: "json",
            success: function (data) {
                let notificationList = $(".dropdown-notifications-list ul");
                notificationList.empty();

                if (data.length > 0) {
                    data.forEach((notification) => {
                        let notificationItem = `
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                     <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-bell"
                                  > <i class="ti ti-bell ti-md"></i></span>
                              </div>
                                </div>
                                <div class="flex-grow-1">
                                    <small class="mb-1 d-block text-body">${notification.message}</small>
                                    <small class="text-muted">${notification.time_ago}</small>
                                </div>
                               
                            </div>
                        </li>`;
                        notificationList.append(notificationItem);
                    });
                } else {
                    notificationList.append(`<li class="list-group-item">No new notifications</li>`);
                }
            }
        });
    }

    // Load notifications every 30 seconds
    loadNotifications();
    setInterval(loadNotifications, 30000);
});

</script>

