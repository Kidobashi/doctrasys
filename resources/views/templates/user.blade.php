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
<html lang="en" >
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
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Biryani&family=Raleway:wght@600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- In the <head> section of your layout file -->
        {{-- <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}"> --}}

        <!-- Before the closing </body> tag of your layout file -->
        {{-- <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    </head>
    {{-- <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Stylesheets -->
        <link href="https://fonts.googleapis.com/css2?family=Biryani&family=Raleway:wght@600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.js"></script>

        <!-- Fontawesome -->
        <script src="https://kit.fontawesome.com/7e4de09da3.js" crossorigin="anonymous"></script>
</head> --}}

<body>

<style>
/* Import the Montserrat font from Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

/* Set the font family for the body element */
html, body {
    background-color: rgb(235, 221, 196);
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

.levitating-div {
  box-shadow: 0 15px 15px rgba(0, 0, 0, 0.2);
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

.fa-sharp, .side-navbar a:hover:not(.active) {
  box-shadow: inset 550px 0 0 0 #000000;
  color: white;
  border-radius: 10px;
}

</style>
@if (session('verified'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Verification successful',
    });
</script>
@endif

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
            @foreach ($errors->all() as $error)
                toastr.error("{{ session('error') }}");
            @endforeach
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
<!-- <script src="/node_modules/@fortawesome/fontawesome-free/js/all.min.js"></script> -->

  <script>
    $(document).ready(function () {

    $('ul.nav-item > li')
            .click(function (e) {
            $('ul.nav-item > li')
                .removeClass('active');
            $(this).addClass('active');
        });
    });
  </script>

</body>
</html>
