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
    <div class="container-fluid col-lg-6">
        <div class="row">
            <div class="col-xxs-6 col-xs-4">
                <h4 class="card-title">Document Details</h4>
                            <hr>
                        <div class="d-flex flex-column" style="display: flex; align-items: center; justify-content: center;">
                            <h5>Reference No.: {{$data->referenceNo}}</h5>
                            <h5>Sender: {{$data->senderName}}</h5>

                            <h5>From Office: {{$data->officeName}}</h5>

                            <div class="col-xxs-6">
                                <img src="{{ asset('qrcodes/qr'.$data->referenceNo.'.png') }}" alt="tag">
                            </div>

                            <hr style="border: 3px solid">

                            <h3>Options</h3>
                            @if($light->action == 2)
                                <button type="button" class="btn btn-secondary" disabled><a href="{{ url('forward/'.$data->referenceNo) }}">Forward</a></button>
                                <button type="button" class="btn btn-success"><a href="{{ url('receive/'.$data->referenceNo) }}">Receive</a></button>
                            @endif
                            @if($light->action == 1)
                                <button type="button" class="btn btn-primary"><a href="{{ url('forward/'.$data->referenceNo) }}">Forward</a></button>
                                <button type="button" class="btn btn-secondary" disabled><a href="{{ url('receive/'.$data->referenceNo) }}">Receive</a></button>
                            @endif
                        </div>
            </div>
            <div class="col-xxs-6 col-xs-4">
                <h3>Tracking Information</h3>
                    <div class="card" style="">
                        @foreach($altdata['prev'] as $key => $prev)
                        <ul class="list-group list-group-flush">
                        <div class="section-header">
                            <li>
                            @if( $altdata['trackings'][$key]->action == 1)
                            <h5>Received by {{ $altdata['trackings'][$key]->receiverName }}</h5>
                                <li class="list-group-item">Office: <i>{{ $altdata['trackings'][$key]->officeName }}</i></li>
                                <li class="list-group-item">Date Received: <i>{{ date_format($altdata['trackings'][$key]->created_at,'M d Y h:i')}}</i></li>
                                @if($altdata['trackings'][$key]->action == 2)
                                <p><li class="list-group-item">Status: <i>In Circulation</i></p>
                                @endif
                                @if($altdata['trackings'][$key]->action == 1)
                                    <p><li class="list-group-item">Status: <i>On Hold</i></p>
                                @endif
                            @endif
                            @if( $altdata['trackings'][$key]->action == 2)
                            <h5>Forwarded by {{ $altdata['trackings'][$key]->receiverName }}</h5>
                                <li class="list-group-item">Forwarded to: <i>{{ $altdata['trackings'][$key]->officeName }}</i></li>
                                <li class="list-group-item">Date Forwarded: <i>{{ date_format($altdata['trackings'][$key]->created_at,'M d Y h:i')}}</i></li>
                                <li class="list-group-item">Forwarded from: <p><b>{{ $altdata['trackings'][$key]->prevReceiver }}</b> - <i>{{ $altdata['prev'][$key]->officeName }}</i></p></li>
                                @if($altdata['trackings'][$key]->action == 2)
                                <p><li class="list-group-item">Status: <i>In Circulation</i></p>
                                @endif
                                @if($altdata['trackings'][$key]->action == 1)
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
        <hr>
        <footer>
            <div class="row">
                <div class="col-md-6">
                    <p>Copyright &copy; 2021 Tutorial Republic</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-dark">Terms of Use</a>
                    <span class="text-muted mx-2">|</span>
                    <a href="#" class="text-dark">Privacy Policy</a>
                </div>
            </div>
        </footer>
    </div>
    </body>
</html>
