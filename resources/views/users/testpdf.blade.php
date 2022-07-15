<!DOCTYPE html>
<html>
<head>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
    <title>Laravel 8 Generate PDF From View</title>
</head>
<body>
    {{-- <h1>{{ $title }}</h1>
    <p>{{ $date }}</p> --}}
    <div class="container" style="position: absolute; right:1px;">
        @include('partials.qrcode')
    </div>
</body>
</html>
