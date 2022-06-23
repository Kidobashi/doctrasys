<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
    <title>Document</title>
</head>
<body>
    <style>
        * {
          box-sizing: border-box;
        }

        .row::after {
          content: "";
          clear: both;
          display: block;
        }

        [class*="col-"] {
          float: left;
          padding: 15px;
        }

        /* For desktop: */
        .col-1 {width: 8.33%;}
        .col-2 {width: 16.66%;}
        .col-3 {width: 25%;}
        .col-4 {width: 33.33%;}
        .col-5 {width: 41.66%;}
        .col-6 {width: 50%;}
        .col-7 {width: 58.33%;}
        .col-8 {width: 66.66%;}
        .col-9 {width: 75%;}
        .col-10 {width: 83.33%;}
        .col-11 {width: 91.66%;}
        .col-12 {width: 100%;}

        @media only screen and (max-width: 768px) {
          /* For mobile phones: */
          [class*="col-"] {
            width: 100%;
          }
        }
        </style>
    <div class="container">
        <div class="col-3">
            <div class="d-flex justify-content-center">
                <div class="card-body">
                    <h4 class="card-title">QR Document Details</h4>
                    <h5>Reference No.: {{$data->referenceNo}}</h5>
                    <h5>Sender: {{$data->senderName}}</h5>
                    <h5>Receiver: {{$data->receiverName}}</>
                    <h5>From Office: {{$data->officeName}}</h5>
                <Label>Options</Label>
                <a href=""><button type="button" class="btn btn-primary">Forward</button></a>
                <a href=""><button type="button" class="btn btn-success">Receive</button></a>
                </div>
                <div class="qrcontainer">
                    <img src="{{ asset('qrcodes/qr'.$data->referenceNo.'.png') }}" alt="tag" style="margin-left:160px;">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
