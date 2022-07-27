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
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- Bootsgrap CSS file -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"> --}}
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="multiple-form-submit-prevent.css">

    <!-- Bootstrap & jQuery file -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Link to your Javascript file -->
    <script src="multiple-form-submit-prevent.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Biryani&family=Raleway:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>

<body>

{{-- @include('layouts.navbars.auth.nav') --}}
<style>
*{
    font-family: 'Biryani', sans-serif;
    font-family: 'Raleway', sans-serif;
    font-style: normal;
}
.content {
    width: 100%;
    float: right;
}
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
  position: relative;
  margin: 0;
  padding: 0;
  width: 100%;
  background-color: #f1f1f1;
  overflow: hidden;
  z-index: 99;
}

.side-navbar a {
  display: block;
  color: white;
  padding: 20px;
  text-decoration: none;
}

.side-navbar a.active {
  background-color: #1B3FAB;
  border-radius: 10px;
  color: white;
}

.side-navbar a:hover:not(.active) {
  background-color: #555;
  border-radius: 10px;
  color: white;
}

.side-navbar ul{
    background: #04426E;
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
    display: block;
  }
  .side-navbar {
      display: block;
    }
  div.content {
      margin-left: 0;
    }
  .display-4{
      font-size: 28px;
  }
  .content{
      position: relative;
      justify-content: center;
  }
}

@media screen and (max-width: 400px) {
  .side-navbar a {
    text-align: center;
    float: none;
  }

}
@media screen and (max-width: 950px) {
    .side-navbar {
    width: 100%;
    height: auto;
    position: relative;
    display: block;
    justify-content: center;
  }
  div.content {
      margin-left: 0;
    }
  .content{
      position: relative;
      justify-content: center;
  }

  .display-4{
      font-size: 28px;
  }

  .side-navbar a {
    text-align: center;
    float: none;
  }
}

@media screen and (max-width: 600px) {
    .side-navbar {
    width: 100%;
    height: auto;
    position: relative;
    display: block;
    justify-content: center;
  }
  div.content {margin-left: 0;}
  .content{
      position: relative;
      justify-content: center;
  }
  .display-4{
      font-size: 24px;
  }

  .side-navbar a {
    text-align: center;
    float: none;
  }
}

@media screen and (max-width: 1500px) {
    .side-navbar {
    width: 100%;
    height: auto;
    position: relative;
    display: block;
  }
  .side-navbar {
      text-align: center;
    }
div.content {
    margin-left: 0;
}
  .content{
      position: relative;
      justify-content: center;
  }
  .display-4{
      font-size: 24px;
  }

  .side-navbar a {
    text-align: center;
    float: none;
  }
}
</style>

<div class="side-navbar active-nav d-flex justify-content-between" id="sidebar">
    <ul class="nav text-white w-100">
      <a href="{{ route('dashboard') }}" class="nav-link h3 text-white my-2">
        <span>Document Tracking System</span>
      </a>
      <li href="#" class="nav-link">
        <a class="nav-link {{ (Request::is('index') ? 'active' : '') }}" href="{{ url('index') }}">
            <span class="mx-2">Tracking</span>
        </a>
      </li>
      {{-- <li href="#" class="nav-link">
        <a class="nav-link" href="{{ url('coming') }}">
            <span class="mx-2">Profile</span>
        </a>
      </li> --}}
      @auth
      <li href="#" class="nav-link">
        <a class="nav-link {{ (Request::is('add-document') ? 'active' : '') }}" href="{{ url('add-document') }}">
            <span class="mx-2">Create&nbsp;Document</span>
        </a>
        </a>
      </li>
      @endauth
      @guest
            <li class="nav-link" style="position: absolute; right: 0; padding-right: 25px;">
                <a href="{{ url('/login')}}" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none text-white">Login</span>
                </a>
            </li>
        @endguest
        @auth
        <li class="nav-link" style="position: absolute; right: 0; padding-right: 25px;">
            <a href="{{ url('/logout')}}" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1 white"></i>
                <span class="d-sm-inline d-none text-white">{{ Auth::user()->name }} | Sign Out</span>
            </a>
        </li>
        @endauth
    </ul>
</div>

  <div class="content">
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
  {{-- @include('layouts.footers.auth.footer') --}}
</body>

</html>
