<!doctype html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{asset('')}}"
  data-template="horizontal-menu-template"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

      <title>{{ config('app.name', 'HATS') }}</title>

    <meta name="description" content="" />

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

    <link rel="stylesheet" href="{{asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}} "/>
    <link rel="stylesheet" href="{{asset('vendor/libs/typeahead-js/typeahead.css')}}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('vendor/libs/@form-validation/form-validation.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('vendor/css/pages/page-auth.css')}}" />

    <!-- Helpers -->
    <script src="{{asset('vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{asset('vendor/js/template-customizer.js')}}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('js/config.js')}}"></script>
  </head>

  <body>
    <!-- Content -->
    <div class="authentication-wrapper authentication-cover">
      <!-- /Logo -->
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-8 p-0">
          <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
            <img
              src="{{asset('img/avatars/logo.png')}}"
              alt="auth-login-cover"
              class="my-5 auth-illustration"
               />
          </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-12 p-6">
          <div class="w-px-400 mx-auto mt-12 pt-5">
            <h4 class="mb-1">Welcome to HATS! 👋</h4>
            <p class="mb-6">Please sign-in to your account and start the adventure</p>
            @if ($errors->any())
              <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
          @endif
            <form id="formAuthentication" class="mb-4"  method="POST" action="{{ route('adminlogin') }}">
            @csrf
             <div class="mb-6">
                <label for="email" class="form-label">Email</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="Enter your email"
                  autofocus />
              </div>
              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
              </div>
              <div class="my-8">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0 ms-2">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                  <a href="">
                    <p class="mb-0">Forgot Password?</p>
                  </a>
                </div>
              </div>
              <button class="btn btn-primary d-grid w-100">Sign in</button>
            </form>

          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>
    

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

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
    <script src="{{asset('vendor/libs/@form-validation/popular.js')}}"></script>
    <script src="{{asset('vendor/libs/@form-validation/bootstrap5.js')}}"></script>
    <script src="{{asset('vendor/libs/@form-validation/auto-focus.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('js/pages-auth.js')}}"></script>
  </body>
</html>