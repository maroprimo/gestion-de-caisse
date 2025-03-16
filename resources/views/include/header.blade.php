<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
      <div class="navbar-logo">
        <a class="mobile-menu" id="mobile-collapse" href="#!">
          <i class="ti-menu"></i>
        </a>
        <a class="mobile-search morphsearch-search" href="#">
          <i class="ti-search"></i>
        </a>
        <a href="index.html">
          <img class="img-fluid" src="{{ asset('images/logo.png') }}" alt="Theme-Logo">
        </a>
        <a class="mobile-options">
          <i class="ti-more"></i>
        </a>
      </div>
      <div class="navbar-container container-fluid">
        <ul class="nav-left">
          <li>
            <div class="sidebar_toggle">
              <a href="javascript:void(0)">
                <i class="ti-menu"></i>
              </a>
            </div>
          </li>
          <li>
            <a href="#!" onclick="toggleFullScreen()">
              <i class="ti-fullscreen"></i>
            </a>
          </li>
        </ul>
        <ul class="nav-right">
          <li class="header-notification">
            <a href="#!">
              <i class="ti-bell"></i>
              <span class="badge bg-c-pink"></span>
            </a>
            <ul class="show-notification">
              <li>
                <h6>Notifications</h6>
                <label class="label label-danger">New</label>
              </li>
              <li>
                <div class="media">
                  <img class="d-flex align-self-center" src="{{ asset('images/user.png') }}" alt="Generic placeholder image">
                  <div class="media-body">
                    <h5 class="notification-user">Notification</h5>
                    <p class="notification-msg">notif</p>
                    <span class="notification-time">30 minutes ago</span>
                  </div>
                </div>
              </li>
              
            </ul>
          </li>
          <li class="user-profile header-notification">
            <a href="#!">
              <img src="{{ asset('images/avatar-4.jpg') }}" class="img-radius" alt="User-Profile-Image">
              <span>Maro Randri</span>
              <i class="ti-angle-down"></i>
            </a>
            <ul class="show-notification profile-notification">
              <li>
                <a href="#!">
                  <i class="ti-settings"></i>Settings </a>
              </li>
              <li>
                <a href="#">
                  <i class="ti-user"></i>Profile </a>
              </li>
              <li>
                <a href="#">
                  <i class="ti-email"></i>My Messages </a>
              </li>
              <li>
                <a href="#">
                  <i class="ti-lock"></i>Lock Screen </a>
              </li>
              <li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>

              <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="ti-layout-sidebar-left"></i>Logout </a>
              
                  
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>