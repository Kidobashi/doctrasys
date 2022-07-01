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
.section-header {
  justify-content: space-between;
}

ul:first-child{
    color: red;
    background: aquamarine;
}

</style>

    @include('layouts.navbars.auth.nav')
        <div class="row">
            <div class="col-md-3">
                    <div class="card-body my-auto" style="margin-left: 12px; border: 1px solid black">
                        <h4 class="card-title">Document Details</h4>
                        <hr>
                        <h5>Reference No.: {{$data->referenceNo}}</h5>
                        <h5>Sender: {{$data->senderName}}</h5>

                        <h5>From Office: {{$data->officeName}}</h5>

                        <Label>Options</Label>
                        <a href="{{ url('forward/'.$data->referenceNo) }}"><button type="button" class="btn btn-primary">Forward</button></a>
                        <a href="{{ url('receive/'.$data->referenceNo) }}"><button type="button" class="btn btn-success">Receive</button></a>
                    </div>
                    <div class="">
                        <img src="{{ asset('qrcodes/qr'.$data->referenceNo.'.png') }}" alt="tag" style="margin-left:160px;">
                    </div>
            </div>

            <div class="col-md-6">
                <h3>TRACKING</h3>
                <div class="card" style="width: 30rem;">
                    @foreach($trackings as $tracking)
                    <ul class="list-group list-group-flush">
                    <div class="section-header">
                        <li>
                        @if( $tracking->action == 1)
                        <h5>Received by {{ $tracking->receiverName }}</h5>
                            <li class="list-group-item">Office: <i>{{ $tracking->officeName }}</i></li>
                            <li class="list-group-item">Date Received: <i>{{ date_format($tracking->created_at,'M d Y h:i')}}</i></li>
                            @if($tracking->action == 2)
                            <p><li class="list-group-item">Status: <i>In Circulation</i></p>
                            @endif
                            @if($tracking->action == 1)
                                <p><li class="list-group-item">Status: <i>On Hold</i></p>
                            @endif
                        @endif
                        @if( $tracking->action == 2)
                        <h5>Forwarded by {{ $tracking->receiverName }}</h5>
                            <li class="list-group-item">Office: <i>{{ $tracking->officeName }}</i></li>
                            <li class="list-group-item">Date Forwarded: <i>{{ date_format($tracking->created_at,'M d Y h:i')}}</i></li>
                            @if($tracking->action == 2)
                            <p><li class="list-group-item">Status: <i>In Circulation</i></p>
                            @endif
                            @if($tracking->action == 1)
                                <p><li class="list-group-item">Status: <i>On Hold</i></p>
                            @endif
                            </li>
                        @endif
                            </li>
                        </div>
                    </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </body>
</html>
