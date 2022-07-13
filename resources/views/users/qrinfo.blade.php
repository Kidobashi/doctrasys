{{-- <!DOCTYPE html>
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
<body> --}}
@extends('templates.user')
@section('content')
<style>
.section-header {
  justify-content: space-between;
}

#latestTrack, #latestTrack h5{
    color: white;
    background:#1B3FAB;
    padding-bottom: 15px;
    border-radius: 20px;
    padding: 10px;
    text-align: center;
    list-style: none;
}

#tracking ul:first-child{
    display: none;
}
ul:first-child h5{
    color: white;
}

ul:not(first-child) li{
    color: black;
    list-style-type: none;
}

ul:not(first-child) ul{
    color: black;
    list-style-type: circle;
}


#tracking {
  display: none;
}

#tracking:target{
  display: block;
}
</style>
    <div class="container-fluid col-lg-4">
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
                            @if($light->action == 3)
                                <button type="button" class="btn btn-secondary" disabled><a href="{{ url('forward/'.$data->referenceNo) }}">Forward</a></button>
                                <button type="button" class="btn btn-success"><a href="{{ url('receive/'.$data->referenceNo) }}">Receive</a></button>
                            @endif
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
            <hr>
            <h3>Tracking Information</h3>
            <div class="col-xxs-6 col-xs-4" id="latestTrack">
                    <div>
                        @if ($light->action == 3)
                            <h5>In Circulation...</h5>
                        @elseif( $light->action == 1)
                            <h5>&nbsp;Received by <i>{{ $light->receiverName }}</i></h5>
                                <li class="">Office: <i>{{ $light->officeName }}</i></li>
                                <li class="">Date Received: <i>{{ date_format($light->created_at,'M d Y h:i A')}}</i></li>
                                @if($light->action == 2)
                                <p><li class="">Status: <i>In Circulation</i></p>
                                @endif
                                @if($light->action == 1)
                                    <p><li class="">Status: <i>Processing...</i></p>
                                <a href="#tracking"><button class="btn btn-primary" style="background:white; color:#1B3FAB;">Show Tracking</button></a>
                                @endif
                            {{-- @endif --}}
                            @elseif( $light->action == 2)
                            <h5>&nbsp;Forwarded by <i>{{ $light->receiverName }}</i></h5>
                                <li class="">Forwarded to: <i>{{ $light->officeName }}</i></li>
                                <li class="">Date Forwarded: <i>{{ date_format($light->created_at,'M d Y h:i a')}}</i></li>
                                <li class="">Forwarded from: <b>{{ $light->prevReceiver }}</b> - <i>{{ $lightPrev->officeName }}</i></li>
                                @if($light->action == 2)
                                <p><li class="">Status: <i>In Circulation</i></p>
                                @endif
                                @if($light->action == 1)
                                    <p><li class="">Status: <i>Processing...</i></p>
                                @endif
                                </li>
                                <a href="#tracking"><button class="btn btn-primary" style="background:white; color:#1B3FAB;">Show Tracking</button></a>
                            @endif
                    </div>
            </div>
            <div class="justify-content-center">
                @include('partials.comments')
                @foreach ($comments as $comment)
                    <div class="m-3 bg-white p-3 pt-5 rounded shadow">
                        <div class="d-flex">
                            <div class="mr-2 d-flex flex-col justify-center">
                                <div>
                                    <?php
                                        $parts = explode(' ', $comment->author);
                                        $initials = strtoupper($parts[0][0] . $parts[count($parts) - 1][0]);
                                    ?>
                                    <span class="bg-gray-300 p-3 rounded-circle"><strong>{{ $initials }}</strong></span>
                                </div>

                                <div class="d-flex flex-col justify-content-center">
                                    <p class="mr-2"><strong>&nbsp;&nbsp;{{ $comment->author }}</strong> &nbsp;&nbsp;&nbsp;</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 ">
                            <p>{{ $comment->text }}</p>
                        </div>
                        <p class="text-gray-600" style="font-family: Helvetica, sans-serif; font-size:13px;position: relative; left: 1px;">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>

    <div class="card" style="" id="tracking">
            @foreach($altdata['prev'] as $key => $prev)
            <ul class="list-group list-group-flush">
            <div class="section-header">
                <li>
                @if( $altdata['trackings'][$key]->action == 1)
                <h5>&nbsp;Received by <i>{{ $altdata['trackings'][$key]->receiverName }}</i></h5>
                    <li class="">Office: <i>{{ $altdata['trackings'][$key]->officeName }}</i></li>
                    <li class="">Date Received: <i>{{ date_format($altdata['trackings'][$key]->created_at,'M d Y h:i A')}}</i></li>
                    @if($altdata['trackings'][$key]->action == 2)
                    <p><li class="">Status: <i>In Circulation</i></p>
                    @endif
                    @if($altdata['trackings'][$key]->action == 1)
                        <p><li class="">Status: <i>Processing...</i></p>
                    @endif
                @endif
                @if( $altdata['trackings'][$key]->action == 2)
                <h5>&nbsp;Forwarded by <i>{{ $altdata['trackings'][$key]->receiverName }}</i></h5>
                    <li class="">Forwarded to: <i>{{ $altdata['trackings'][$key]->officeName }}</i></li>
                    <li class="">Date Forwarded: <i>{{ date_format($altdata['trackings'][$key]->created_at,'M d Y h:i a')}}</i></li>
                    <li class="">Forwarded from: <b>{{ $altdata['trackings'][$key]->prevReceiver }}</b> - <i>{{ $altdata['prev'][$key]->officeName }}</i></li>
                    @if($altdata['trackings'][$key]->action == 2)
                    <p><li class="">Status: <i>In Circulation</i></p>
                    @endif
                    @if($altdata['trackings'][$key]->action == 1)
                        <p><li class="">Status: <i>Processing...</i></p>
                    @endif
                    </li>
                @endif
                    </li>
                </div>
            </ul>
            <hr>
        @endforeach
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
    <script id="dsq-count-scr" src="//testcomment-6.disqus.com/count.js" async></script>
    </body>
</html>
@endsection
