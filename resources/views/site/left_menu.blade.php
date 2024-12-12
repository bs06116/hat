<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="" class="app-brand-link">
            <img src="{{asset('img/avatars/logo.png')}}"  style="width: 90px; height: auto;">

            </a>

            <!-- <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
              <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
            </a> -->
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item {{ request()->is('SiteDashboard*') ? ' active' : '' }}">
            <a href="{{route(name: "site.dashboard")}}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Home">Home</div>
              </a>
            </li>
            
            <li class="menu-item {{ request()->is('users*') ? ' active' : '' }}">
            <a href="{{route("users.index")}}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-user"></i>
                <div data-i18n="Admins">Admins</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('drivers*') ? ' active' : '' }}">
            <a href="{{route("drivers.index")}}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-truck"></i>
                <div data-i18n="Drivers">Drivers</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('locations*') ? ' active' : '' }}">
            <a href="{{route("locations.index")}}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-map-pin"></i>
                <div data-i18n="Locations">Locations</div>
              </a>
            </li>
            
            <li class="menu-item {{ request()->is('jobs*') ? ' active' : '' }}">
            <a href="{{route("jobs.index")}}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-briefcase"></i>
                <div data-i18n="Jobs">Jobs</div>
              </a>
            </li>  
            <!-- <li class="menu-item ">
            <a href="" class="menu-link">
            <i class="menu-icon tf-icons ti ti-bell"></i>
                <div data-i18n="Notifications">Notifications</div>
              </a>
            </li> -->
            <li class="menu-item {{ request()->is('invoice*') ? ' active' : '' }}">
            <a href="{{route("invoice.index")}}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-invoice"></i>
                <div data-i18n="Invoicing">Invoicing</div>
              </a>
            </li>  
            <!-- <li class="menu-item {{ request()->is('user/profile*') ? ' active' : '' }}">
            <a href="{{route("user.profile.edit")}}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-user"></i>
                <div data-i18n="Profile">Profile</div>
              </a>
            </li> -->
          </ul>
        </aside>