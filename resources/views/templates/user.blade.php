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

    <!-- Fontawesome -->
    {{-- <link rel="icon" href="../../../public/images/CMU-LOGO.png"> --}}

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" /> --}}
    <!-- Bootsgrap CSS file -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"> --}}
    <!-- Link to your CSS file -->
    {{-- <link rel="stylesheet" href="multiple-form-submit-prevent.css"> --}}
    {{-- <script src="multiple-form-submit-prevent.js"></script> --}}

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


</head>

<body>

<style>
/* Import the Montserrat font from Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

/* Set the font family for the body element */
body {
  font-family: 'Montserrat', sans-serif;
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
  border-radius: 10px;
  box-shadow: 0px 10px 20px #c2c2c2, 0px -10px 20px #ffffff;
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
  overflow: hidden;
  z-index: 99;
}

.side-navbar a {
  display: block;
  color: white;
  margin-top: 5px;
  padding: 12px;
  text-decoration: none;
  font-weight: 800;
  border-radius: 10px;
  box-shadow: inset 0 0 0 0 #000000;
  transition: color .25s ease-in-out, box-shadow .25s ease-in-out;
}

.side-navbar a.active {
  background-color: #000000;
  border-radius: 10px;
}

.fa-sharp, .side-navbar a:hover:not(.active) {
  box-shadow: inset 550px 0 0 0 #000000;
  color: white;
  border-radius: 10px;
}

div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 100%;
  padding-bottom: 50px;
}
</style>
@include('layouts.navbars.auth.nav')

  <div class="content">
        @yield('content')
  </div>

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
