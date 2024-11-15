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
            <li class="menu-item {{ request()->is('DriverDashboard*') ? ' active' : '' }}">
            <a href="{{route(name: "driver.dashboard")}}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
              </a>
            </li>
            
            <li class="menu-item {{ request()->is('job*') ? ' active open' : '' }} ">
              
              <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons ti ti-briefcase"></i>

                      <div data-i18n="Jobs">Jobs</div>
                    </a>
              <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('jobs/available') ? ' active' : '' }} ">
                    <a href="{{route("jobs.available")}}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-mail"></i>
                    <div data-i18n="Available Jobs">Available Jobs</div>
                      </a>
                    </li>
                    <li class="menu-item {{ request()->is('jobs/won') ? ' active' : '' }}">
                      
                      <a href="{{route("jobs.won")}}" class="menu-link">

                        <div data-i18n="Won Jobs">Won Jobs</div>
                      </a>
                    </li>
                    </ul>
            </li>
            <li class="menu-item ">
            <a href="" class="menu-link">
            <i class="menu-icon tf-icons ti ti-bell"></i>
                <div data-i18n="Notifications">Notifications</div>
              </a>
            </li>
            <li class="menu-item ">
            <a href="" class="menu-link">
            <i class="menu-icon tf-icons ti ti-receipt"></i>
                <div data-i18n="Invoicing">Invoicing</div>
              </a>
            </li>
            <li class="menu-item {{ request()->is('user/profile*') ? ' active' : '' }}">
            <a href="{{route("user.profile.edit")}}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-user"></i>
                <div data-i18n="Profile">Profile</div>
              </a>
            </li>
           
          </ul>
        </aside>