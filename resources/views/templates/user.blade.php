<!--
=========================================================
* Soft UI Dashboard - v1.0.3
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>

@if (\Request::is('rtl'))
  <html dir="rtl" lang="ar">
@else
  <html lang="en" >
@endif

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100 {{ (\Request::is('rtl') ? 'rtl' : (Request::is('virtual-reality') ? 'virtual-reality' : '')) }} ">
  {{-- @auth
    @yield('auth')
  @endauth
  @guest
    @yield('guest')
  @endguest

  @if(session()->has('success'))
    <div x-data="{ show: true}"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        class="position-fixed bg-success rounded right-3 text-sm py-2 px-4">
      <p class="m-0">{{ session('success')}}</p>
    </div>
  @endif
    <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/fullcalendar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  @stack('rtl')
  @stack('dashboard')
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
 --}}

@include('layouts.navbars.auth.nav')
  <style>
.my-container {
  transition: 0.4s;
}
.active-nav {
  margin-left: 0;
}
/* for main section */
.active-cont {
  margin-left: 180px;
}

.side-navbar {
  margin: 0;
  padding: 0;
  width: 200px;
  background-color: #f1f1f1;
  position: fixed;
  height: 100%;
  overflow: auto;
}

.side-navbar a {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
}

.side-navbar a.active {
  background-color: #1B3FAB;
  color: white;
}

.side-navbar a:hover:not(.active) {
  background-color: #555;
  color: white;
}

div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

@media screen and (max-width: 700px) {
  .side-navbar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .side-navbar {float: left;}
  div.content {margin-left: 0;}
}

@media screen and (max-width: 400px) {
  .side-navbar a {
    text-align: center;
    float: none;
  }
}
/* #menu-btn {
  background-color: #100901;
  color: #fff;
  margin-left: -62px;
} */
</style>

<div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column" id="sidebar">
    <ul class="nav flex-column text-white w-100">
      <a href="{{ route('dashboard') }}" class="nav-link h3 text-white my-2">
        <span>Document Tracking System</span>
      </a>
      <li href="#" class="nav-link">
        <a class="nav-link {{ (Request::is('user-documents') ? 'active' : '') }}" href="{{ url('user-documents') }}">
            <span class="mx-2">Dashboard</span>
        </a>
      </li>
      <li href="#" class="nav-link">
        <a class="nav-link" href="{{ url('user-profile') }}">
            <span class="mx-2">Profile</span>
        </a>
      </li>
      <li href="#" class="nav-link">
        <a class="nav-link {{ (Request::is('add-document') ? 'active' : '') }}" href="{{ url('add-document') }}">
            <span class="mx-2">Add Document</span>
        </a>
        </a>
      </li>
    </ul>
</div>

  <div class="content" style="width: 100%; float:right; margin-top:20px;">
        @yield('content')
  </div>

  <script>
      var menu_btn = document.querySelector("#iconNavbarSidenav");
      var sidebar = document.querySelector("#sidebar");
      var container = document.querySelector(".my-container");
      menu_btn.addEventListener("click", () => {
      sidebar.classList.toggle("active-nav");
      container.classList.toggle("active-cont");
    });
  </script>
</body>

</html>
