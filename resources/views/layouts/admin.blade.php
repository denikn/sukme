<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" name="viewport">
  <title>Dashboard &mdash; {{ $site_config->sip_trx_site_configs_title }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('sip/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('sip/modules/ionicons/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('sip/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css') }}">

  <link rel="stylesheet" href="{{ asset('sip/modules/summernote/summernote-lite.css') }}">
  <link rel="stylesheet" href="{{ asset('sip/modules/flag-icon-css/css/flag-icon.min.css') }}">
  <link rel="stylesheet" href="{{ asset('sip/css/demo.css') }}">
  <link rel="stylesheet" href="{{ asset('sip/css/style.css') }}">
</head>

<body>
  <div id="app">

    @if (Auth::check())
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="ion ion-navicon-round"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="ion ion-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            <button class="btn" type="submit"><i class="ion ion-search"></i></button>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg">
            <i class="ion ion-android-person d-lg-none"></i>
            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->user_name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="{{ route('profile_admin') }}" class="dropdown-item has-icon">
                <i class="ion ion-android-person"></i> Profile
              </a>
              <a href="{{ route('logout_admin') }}" class="dropdown-item has-icon">
                <i class="ion ion-log-out"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ $site_config->sip_trx_site_configs_title }}</a>
          </div>
          <div class="sidebar-user">
            <div class="sidebar-user-picture">
              <img alt="image" src="{{ asset('sip/img/avatar/avatar-1.jpeg') }}">
            </div>
            <div class="sidebar-user-details">
              <div class="user-name">{{ Auth::user()->user_name }}</div>
              <div class="user-role">
                Administrator
              </div>
            </div>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="active">
              <a href="{{ route('dashboard_admin') }}"><i class="ion ion-speedometer"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Management</li>
            <li>
              <a href="#" class="has-dropdown"><i class="ion ion-ios-albums-outline"></i><span>Setting</span></a>
              <ul class="menu-dropdown">
                <li><a href="{{ route('index_config_admin') }}"><i class="ion ion-ios-circle-outline"></i> Website</a></li>
                <li><a href="{{ route('index_puskesmas_admin') }}"><i class="ion ion-ios-circle-outline"></i> Profile Puskesmas</a></li>
              </ul>
            </li>
            <li>
              <a href="#" class="has-dropdown"><i class="ion ion-ios-albums-outline"></i><span>User</span></a>
              <ul class="menu-dropdown">
                <li><a href="{{ route('list_member_admin') }}"><i class="ion ion-ios-circle-outline"></i> List</a></li>
                <li><a href="{{ route('list_permission_admin') }}"><i class="ion ion-ios-circle-outline"></i> Permission</a></li>
              </ul>
            </li>
            <li>
              <a href="#" class="has-dropdown"><i class="ion ion-ios-albums-outline"></i><span>Form</span></a>
              <ul class="menu-dropdown">
                <li><a href="{{ route('list_activity_admin') }}"><i class="ion ion-ios-circle-outline"></i> Jenis Kegiatan</a></li>
                <li><a href="{{ route('list_form_admin') }}"><i class="ion ion-ios-circle-outline"></i> Form</a></li>
              </ul>
            </li>
            <li>
              <a href="#" class="has-dropdown"><i class="ion ion-ios-albums-outline"></i><span>Pelaporan</span></a>
              <ul class="menu-dropdown">
                @foreach($shared_activities as $activity)
                <li><a href="#" class="has-dropdown"><i class="ion ion-ios-circle-outline"></i> {{ $activity->sip_ref_activities_name }}</a>
                  
                  <ul class="menu-dropdown">
                    @foreach($activity->forms()->where('sip_ref_forms_status','active')->get() as $form) 
                    <li><a href="{{ route('view_form_admin',['id' => $form->sip_ref_forms_id]) }}"><i class="ion ion-ios-circle-outline"></i> {{ $form->sip_ref_forms_title }}</a></li>
                    @endforeach
                  </ul>
                
                </li>
                @endforeach
              </ul>
            </li>
            <li>
              <a href="#" class="has-dropdown"><i class="ion ion-flag"></i><span>Icons</span></a>
              <ul class="menu-dropdown">
                <li><a href="ion-icons.html"><i class="ion ion-ios-circle-outline"></i> Ion Icons</a></li>
              </ul>
            </li>     
          </ul>
        </aside>
      </div>
      <div class="main-content">
        
        @yield('content')

      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://multinity.com/">Multinity</a>
        </div>
        <div class="footer-right"></div>
      </footer>
    </div>
    @else

        @yield('content')

    @endif

  </div>
  <script src="{{ asset('sip/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('sip/modules/popper.js') }}"></script>
  <script src="{{ asset('sip/modules/tooltip.js') }}"></script>
  <script src="{{ asset('sip/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('sip/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('sip/modules/scroll-up-bar/dist/scroll-up-bar.min.js') }}"></script>
  <script src="{{ asset('sip/js/sa-functions.js') }}"></script>
  
  <script src="{{ asset('sip/modules/chart.min.js') }}"></script>
  <script src="{{ asset('sip/modules/summernote/summernote-lite.js') }}"></script>

  @yield('footer')

  <script src="{{ asset('sip/js/scripts.js') }}"></script>
  <script src="{{ asset('sip/js/custom.js') }}"></script>
  <script src="{{ asset('sip/js/demo.js') }}"></script>

</body>
</html>
