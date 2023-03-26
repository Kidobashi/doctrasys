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
/* Import the Montserrat font from Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

/* Set the font family for the body element */
html, body {
    height: 100%;
    width: 100%;
    font-family: 'Montserrat', sans-serif;
    background-size: cover;
    background-repeat: no-repeat;
}

/* Style the heading element with Montserrat font */
h1, h2, h3, h4, h5, h6 {
  font-family: 'Montserrat', sans-serif;
  font-weight: 600;
  letter-spacing: 1px;
  line-height: 1.2;
}

/* Style the paragraphs with Montserrat font */
p {
  font-family: 'Montserrat', sans-serif;
  font-weight: 400;
  font-size: 1em;
  line-height: 1.5;
}

.neomorphic-bg {
  background-color: #f5f5f5;
  box-shadow: 0px 10px 20px #c2c2c2, 0px -10px 15px #ffffff;
  padding: .7rem;
  border:1px solid #d3d3d3;
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
  transition: all 0.3s ease-in-out;
  margin-left: 5px;
}

.navbar-nav li{
    margin-bottom: 8px;
}

.navbar-nav .nav-link:hover {
  background-color: #007bff;
  color: #fff;
}

.active {
    background-color: #007bff;
    color: #fff;
}

.active span, .active i {
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

#clock span {
  line-height: 0.8em;
}

#date span {
  line-height: 1em;
}

#clock {
    padding-top: 10px;
    padding-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3em;
    font-weight: bold;
    margin-bottom: 20px; /* add margin-bottom to create space between #time and #date */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

#date {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5em;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}


#hours {
  /* font-size: 2em; */
  border-radius: 10px;
  color: #333;
}

#minutes {
  /* font-size: 2em; */
  border-radius: 10px;
  color: #666;
}

#ampm {
  /* font-size: 2em; */
  border-radius: 10px;
  color: #ffffff;
  margin-left: 2px;
}

#weekday {
  font-size: 1.5em;
  color: #999;
}

#month {
  font-size: 1.5em;
  color: #999;
}

#day {
  font-size: 2.5em;
  color: #333;
}

#year {
  font-size: 1.5em;
  color: #999;
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
<div class="container-fluid">
    <div class="row">
      <div class="col-md-2 bg-white position-fixed" style="height: 100%;">
        <!-- First column content here -->
        <div class="container-fluid">
            <div class="m-3 p-2">
                <h3 class="navbar-brand text-wrap"  href="#">CMU DocTraSys</h3>
            </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="navbar" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
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
                    <li class="nav-item" style="position: absolute; top: 755px;">
                        <a href="{{ route('admin.logout') }}" class="nav-link" style="display: flex; align-items: center;">
                            <i class="fas fa-sign-out-alt fa-2x" style="margin-right: 0.5rem;"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
      </div>
      <div class="col-md-7 offset-md-2" style="border: 1px red solid;">
        <!-- Second column content here -->
        @yield('content')
      </div>
      <div class="col-md-3 bg-secondary">
        <!-- Third column content here -->
        <div class="neomorphic-bg" style="border: 1px green solid;">
            <div class="m-0" id="clock">
                <span class="neomorphic-bg" id="hours"></span>
                <span>:</span>
                <span class="neomorphic-bg" id="minutes"></span>
                <span class="neomorphic-bg bg-primary" id="ampm"></span>
            </div>
            <div id="date" style="border: 1px green solid;">
                <span id="weekday"></span>
                <span>, </span>
                <span id="month"></span>
                <span> </span>
                <span id="day"></span>
                <span>, </span>
                <span id="year"></span>
            </div>
        </div>
      </div>
    </div>
  </div>
{{-- <div>
  <div class="row">
    <div class="col-md-2 col-sm-12 p-0 ml-1 mb-3 mb-md-0 position-fixed h-100 neomorphic-bg">
        <div class="container-fluid">
            <div class="m-3 p-2">
                <h3 class="navbar-brand text-wrap"  href="#">CMU DocTraSys</h3>
            </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="navbar" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <span class="material-symbols-outlined" style="vertical-align: middle;">
                                dashboard
                            </span>
                            Dashboard
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <a href="{{ route('admin.offices') }}" class="nav-link" style="display: flex; align-items: center;">
                        <i class="far fa-building fa-2x" style="margin-right: 0.5rem;"></i>
                        <span>Offices</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.docTypes') }}" class="nav-link" style="display: flex; align-items: center;">
                            <i class="far fa-file-alt fa-2x" style="margin-right: 0.5rem;"></i>
                            <span>Document Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#Reports" class="nav-link" style="display: flex; align-items: center;">
                            <i class="far fa-flag fa-2x" style="margin-right: 0.5rem;"></i>
                            <span>Types of Report</span>
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <a href="{{ route('admin.user-management') }}" class="nav-link" style="display: flex; align-items: center;">
                            <i class="fas fa-users-cog fa-2x" style="margin-right: 0.5rem;"></i>
                            <span>User Management</span>
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item" style="position: absolute; top: 755px;">
                        <a href="{{ route('admin.logout') }}" class="nav-link" style="display: flex; align-items: center;">
                            <i class="fas fa-sign-out-alt fa-2x" style="margin-right: 0.5rem;"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-2 p-0">

    </div>
    <div class="col-md-7 col-sm-12 p-0 mb-3 mb-md-0" style="border: 1px red solid;">
      <!-- Middle column content goes here -->
        @yield('content')
    </div>
    <div class="col-md-3 col-sm-12 mt-4 h-100" style="border: 1px red solid;">
      <!-- Third column content goes here -->
        <div class="mb-4">

        </div>
        <div class="neomorphic-bg" style="border: 1px green solid;">
            <div class="m-0" id="clock">
                <span class="neomorphic-bg" id="hours"></span>
                <span>:</span>
                <span class="neomorphic-bg" id="minutes"></span>
                <span class="neomorphic-bg bg-primary" id="ampm"></span>
            </div>
            <div id="date" style="border: 1px green solid;">
                <span id="weekday"></span>
                <span>, </span>
                <span id="month"></span>
                <span> </span>
                <span id="day"></span>
                <span>, </span>
                <span id="year"></span>
            </div>
        </div>
    </div>
  </div> --}}

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
