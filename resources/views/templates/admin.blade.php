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
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap & jQuery file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Link to your Javascript file -->

    <script src="https://kit.fontawesome.com/7e4de09da3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Biryani&family=Raleway:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>

<style>
@import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,400;0,700;1,300;1,600&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap');
html, body {
    height: 100%;
    width: 100%;
    font-family: 'Poppins', sans-serif;
    background-size: cover;
    background-repeat: no-repeat;
    overflow: hidden;
}

/* Style the heading element with Montserrat font */
h1, h2, h3, h4, h5, h6 {
  font-family: 'Poppins', sans-serif;
  font-weight: 600;
  letter-spacing: 1px;
  line-height: 1.2;
}

/* Style the paragraphs with Montserrat font */
p {
  font-family: 'Poppins', sans-serif;
  font-weight: 400;
  font-size: 1em;
  line-height: 1.5;
}

.neomorphic-bg {
  box-shadow: 0px 10px 20px #c2c2c2, 0px -10px 20px #ffffff;
  border:1px solid #d3d3d3;
}

.levitating-div {
  box-shadow: 0 20px 20px rgba(0, 0, 0, 0.2);
  transition: all 0.150s ease-in-out;
}

.levitating-div:hover {
  box-shadow: 0 25px 25px rgba(0, 0, 0, 0.4);
  transform: translateY(-5px);
}

*:not(input) {
  user-select: none;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
}

html, body{
    background-color:#dbdde6;
}

.navbar-nav .nav-link {
  line-height: 1.5;
  font-size: 16px;
  color: #000;
  text-transform: uppercase;
  padding: 10px 20px;
  border-radius: 5px;
  margin-left: 5px;
  box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
  transition: all 0.150s ease-in-out;
}

.navbar-nav li{
    margin-bottom: 8px;
}

.navbar-nav .nav-link:hover {
  background-color: #4682B4;
  color: #fff;
  box-shadow: 0 5px 5px rgba(0, 0, 0, 0.4);
  transform: translateY(-2px);
}

.active {
    background-color: #4682B4;
    color: #fff;
}

.active span, .active i, .active a span{
  color: #fff;
}

@media (min-width: 768px) {
    .navbar mobile  {
      display: none !important;
    }
  }

#dash-icon {
    height: 20px;
    width: 20px;
}

.info-input {
    display: flex;
    align-items: center;
}

.info-input .fa {
    margin-left: 10px;
}

.with-dash-icon {
  display: inline-block;
  padding-right: 20px; /* adjust the spacing between the text and the icon */
  background: url('/images/dash-icon.png') no-repeat left center;
  background-size: 16px 16px; /* adjust the size of the icon */
}

.dash-icon {
  display: inline-block;
  width: 16px; /* adjust the size of the icon */
  height: 16px; /* adjust the size of the icon */
}

.material-symbols-outlined {
    font-size: 30px;
  font-variation-settings:
  'FILL' 0,
  'wght' 400,
  'GRAD' 0,
  'opsz' 48
}

</style>
<div class="container-fluid" style="background:  #A0D6B4;">
    <div class="row">
      <div class="col-md-2 bg-white position-fixed" style="height: 100%;">
        <!-- First column content here -->
        <div class="container-fluid">
            <div class="m-3 p-2">
                <h2 class=""  href="#">CMU DocTraSys</h2>
            </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="navbar" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }} " href="{{ route('admin.dashboard') }}">
                            <span class="material-symbols-outlined" style="vertical-align: middle;">
                                dashboard
                            </span>
                            Dashboard
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <a href="{{ route('admin.offices') }}" class="nav-link {{ Request::is('admin/offices') ? 'active' : '' }}" style="display: flex; align-items: center;">
                        <i class="far fa-building fa-2x" style="margin-right: 0.5rem;"></i>
                        <span>Offices</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.docTypes') }}" class="nav-link {{ Request::is('admin/docType') ? 'active' : '' }}" style="display: flex; align-items: center;">
                            <i class="far fa-file-alt fa-2x" style="margin-right: 0.5rem;"></i>
                            <span>Document Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#Reports" class="nav-link {{ Request::is('admin/reportType') ? 'active' : '' }}" style="display: flex; align-items: center;">
                            <i class="far fa-flag fa-2x" style="margin-right: 0.5rem;"></i>
                            <span>Types of Report</span>
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <a href="{{ route('admin.user-management') }}" class="nav-link {{ Request::is('admin/user-management') ? 'active' : '' }}" style="display: flex; align-items: center;">
                            <i class="fas fa-users-cog fa-2x" style="margin-right: 0.5rem;"></i>
                            <span>User Management</span>
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item" style="position: absolute; top: 740px;">
                        <a href="{{ route('admin.logout') }}" class="nav-link" style="display: flex; align-items: center;">
                            <i class="fas fa-sign-out-alt fa-2x" style="margin-right: 0.5rem;"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
      </div>
      <div class="col-md-7 offset-md-2 px-3" style="height: 960px;">
        <div class="input-group mb-4 mt-5 px-5">
            <div class="col-md-12 d-flex levitating-div rounded">
                <input type="text" class="form-control rounded" placeholder="Search office name ..." aria-label="Search" aria-describedby="search-icon">
                <button class="btn btn-light btn-outline-secondary rounded" type="button" id="search-icon"><i class="fas fa-search fa-2x text-black"></i></button>
            </div>
        </div>
        @yield('content')
      </div>
      <div class="col-md-3 p-0 d-block justify-content-center align-items-center" >
        <!-- Third column content here -->
        <div class="col-md-11 p-3">
            <div class="row mb-1">
              <div class="col-md-5 d-flex text-center">
              </div>
              <div class="col-md-7 d-flex text-center bg-white" style="border-radius: 5px;">
                  <div class="p-3">
                      <i class="fas fa-user-tie fa-3x"></i>
                  </div>
                  <div class="p-3">
                      <p class="mb-0"><strong>{{ Auth::user()->name }}</strong></p>
                      <p class="mb-1 text-secondary"><em>{{ Auth::user()->roles->pluck('name')->implode(', ') }}</em></p>
                  </div>
              </div>
            </div>
        </div>
        <div class="col-md-11 bg-white p-3 levitating-div" style="border-radius: 5px;">
            @include('admin.misc.most-documents-per-office')
        </div>
        <div class="col-md-11 mt-2 bg-white p-2 levitating-div" style="border-radius: 5px;">
            @include('admin.misc.most-types')
        </div>
        </div>
        <div class="col-md-11 mt-2 bg-white p-2 levitating-div" style="border-radius: 5px;">
            @include('admin.misc.clock-with-date')
        </div>
      </div>
    </div>
  </div>

<script>
    $(document).ready(function() {
  // add click event listener to the toggle button
  $('.navbar-toggler').click(function() {
    // toggle the "show" class on the list
    $('.navbar-nav').toggleClass('show');
  });

  // add click event listener to the list items
  $('.navbar-nav .nav-link').click(function() {
    // hide the list when a list item is clicked (only for small screens)
    if ($('.navbar-collapse').hasClass('show')) {
      $('.navbar-collapse').removeClass('show');
    }
  });
});
  </script>
<script>
function updateTime() {
  var now = new Date();
  var hours = now.getHours();
  var minutes = now.getMinutes();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12;
  minutes = minutes < 10 ? '0' + minutes : minutes;
  document.getElementById("hours").innerHTML = hours;
  document.getElementById("minutes").innerHTML = minutes;
  document.getElementById("ampm").innerHTML = ampm;

  // Update date
  var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  var dayOfWeek = days[now.getDay()];
  var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  var month = months[now.getMonth()];
  var day = now.getDate();
  var year = now.getFullYear();
  document.getElementById("weekday").innerHTML = dayOfWeek;
  document.getElementById("month").innerHTML = month;
  document.getElementById("day").innerHTML = day;
  document.getElementById("year").innerHTML = year;
}

updateTime();
setInterval(updateTime, 1000);
</script>
  <script>
    @if(Session::has('message'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('error'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.warning("{{ session('warning') }}");
    @endif
  </script>
<script src="/node_modules/@fortawesome/fontawesome-free/js/all.min.js"></script>

  <script>
    $(document).ready(function () {

    $('ul.nav-item > li')
            .click(function (e) {
            $('ul.nav-item > li')
                .removeClass('active');
            $(this).addClass('active');
        });
    });

    window.addEventListener('alert', event => {
            toastr[event.detail.type](event.detail.message,
            event.detail.title ?? ''), toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
        });
  </script>

  {{-- @include('layouts.footers.auth.footer') --}}
</body>
</html>
