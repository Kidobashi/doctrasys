@extends('templates.user')
@section('content')
<head>
    <title>Tracking Information</title>
</head>
<style>
#sendBack {
    display: none;
}
#forward, #fixIssue {
    display: none;
}

#receive {
    display: none;
}
#message {
    position: fixed;
    text-align: center;
    margin: auto;
    justify-content: center;
    z-index: 2;
}

#message h5{
    padding: 50px 0px;
    color: white;
}
li .comments:nth-child(1){
    display: none;
}

li .comments:nth-child(2){
    display: none;
}

li .comments:nth-child(3){
    display: none;
}

li .comments:nth-child(4){
    display: none;
}

 .container-fluid{
        position: relative;
        top: 20px;
        height: 100%;
    }
.top-arrow {
    position: relative;
    right: 65px;
    border: 3px solid #22303c;
    background-color: #adefd1ff;
    border-radius: 100%;
	display: inline-block;
	width: 1.75rem;
	height: 1.75rem;
	color: #222;
	transform: rotate(-135deg);
    z-index: 10;
}
.card ul{
  border-left: 2px solid green;
  padding-left: 50px;
}

.card ul:last-child {
    border-width: 0;
}
.section-header {
  justify-content: space-between;
}

#latestTrack, #latestTrack h5{
    color: white;
    background: #04426E;
    padding-bottom: 15px;
    border-radius: 20px;
    padding: 10px;
    text-align: center;
    list-style: none;
}

#tracking ul:first-child{
    display: none;
    z-index: 1;
}
ul:first-child h5{
    color: white;
    z-index: 1;
}

ul:not(first-child) li{
    color: black;
    list-style-type: none;
    z-index: 1;
}

ul:not(first-child) ul{
    color: black;
    list-style-type: square;
    z-index: 1;
}

#tracking {
  z-index: 1;
}

#tracking:target{
  display: block;
  z-index: 1;
}

.docDetails {
    display: flex;
}

.vl {
    border: 1px solid black;
    height: 100%;
}

@media screen and (max-width: 700px) {
.highlights {
    margin: 6px;
}
.docDetails {
    display:block;
}
h5{
    font-size: 4.5vw;
}
  #latestTrack li{
    font-size: 14px;
  }
  .section-header h5{
      font-size: 20px;
  }
    #tracking li{
      font-size: 14px;
  }
  .top-arrow {
    /* position: relative; */
    right: 63px;
	width: 1.45rem;
	height: 1.45rem;
    }
}
</style>
This page took {{ (microtime(true) - LARAVEL_START) }} seconds to render
<div class="col-md-12 d-flex justify-content-center">
    <div class="col-md-10 row mx-3 rounded" style="padding:15px; background-color: #f5f5f5;border: 1px solid #d3d3d3;">
        <h2 class="text-center">Document Details</h2>
        <div class="docDetails mt-3">
            <div class="d-inline highlights col-md-4 text-center">
            <p>Reference Number</p>
            <h1>{{$data->referenceNo}}</h1>
            </div>
            <div class="vl"></div>
            <div class="d-inline highlights col-md-4 text-center">
                <p>Document Type</p>
                <h1>@if (isset($docCategory->documentName))
                   {{$docCategory->documentName}}
                    @endif
                </h1>
            </div>
            <div class="vl"></div>
            <div class="d-inline highlights col-md-4 text-center">
                <p>From</p>
                <h1>{{$data->officeName}}</h1>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 d-flex justify-content-center">
    <div class="col-md-10">
        <hr>
    </div>
</div>
<div>

    <div class="container-fluid col-lg-6">
        <div class="row">
            <div class="col-xxs-6 col-xs-4">
            @if(session()->has('success'))
                <div id="message" class="col-lg-5 bg-success rounded right-3 text-sm py-2 px-4">
                    <h5 class="m-0">{{ session('success')}}</h5>
                </div>
            @endif
            @if(session()->has('danger'))
            <div id="message" class="col-lg-5 bg-danger rounded right-3 text-sm py-2 px-4">
                <h5 class="m-0">{{ session('danger')}}</h5>
            </div>
            @endif

                @guest
                    <div class="text-center">
                        <p class="font-italic">Login to modify document</p>
                    </div>
                @endguest

                @auth
                @if (isset($status) && $status->status == 1)
                    <button class="btn btn-success" type="submit" onclick="showReceive()">Receive</button>
                    <button type="button" class="btn btn-secondary" class="text-white" onclick="" disabled>Process</button>
                    <button type="button" class="btn btn-secondary" class="text-white" onclick="showForward()" disabled>Forward</button>
                    <button type="button" class="btn btn-secondary" class="text-white" onclick="showSendBack()" disabled>Send Back</button>
                    <button class="btn btn-secondary text-white" onclick="fixIssue()" type="submit" disabled>Issue Fix</button>
                @endif
                @if (isset($status) && $status->status == 2)
                    <button class="btn btn-secondary" type="submit" onclick="showReceive()" disabled>Receive</button>
                    @if (isset($data->referenceNo))
                        <form action="process/{{ $data->referenceNo }}" method="post">
                            @csrf
                            <input type="text" style="display: none;" value="3" name="status">
                            <button type="submit" class="btn btn-primary" class="text-white" onclick="">Process</button>
                        </form>
                    @endif
                    <button type="button" class="btn btn-secondary" class="text-white" onclick="showForward()" disabled>Forward</button>
                    <button type="button" class="btn btn-secondary" class="text-white" onclick="showSendBack()" disabled>Send Back</button>
                    <button class="btn btn-secondary text-white" onclick="fixIssue()" type="submit" disabled>Issue Fix</button>
                @endif
                @if (isset($status) && $status->status == 3)
                    <button class="btn btn-secondary" type="submit" onclick="showReceive()" disabled>Receive</button>
                    <button type="button" class="btn btn-secondary" class="text-white" onclick="" disabled>Process</button>
                    <button type="button" class="btn btn-info" class="text-white" onclick="showForward()">Forward</button>
                    <button type="button" class="btn btn-danger" class="text-white" onclick="showSendBack()">Send Back</button>
                    <button class="btn btn-secondary text-white" onclick="fixIssue()" type="submit" disabled>Issue Fix</button>
                @endif
                @if (isset($status) && $status->status == 4)
                    <button class="btn btn-secondary" type="submit" onclick="showReceive()" disabled>Receive</button>
                    <button type="button" class="btn btn-primary" class="text-white" onclick="">Process</button>
                    <button type="button" class="btn btn-secondary" class="text-white" onclick="showForward()" disabled>Forward</button>
                    <button type="button" class="btn btn-secondary" class="text-white" onclick="showSendBack()" disabled>Send Back</button>
                    <button class="btn btn-secondary text-white" onclick="fixIssue()" type="submit" disabled>Issue Fix</button>
                @endif

                @endauth
                        @if (isset(Auth::user()->name))
                        <div class="receive" id="receive">
                            <form class="receive" action="received/{{ $data->referenceNo }}" method="post">
                            @csrf
                                <h6>Confirm Receive</h6>

                                <div class="mb-3">
                                    {{-- <input type="text"  style="display:none;" class="form-control" name="receiverOffice" value="{{ Auth::user()->assignedOffice }}"> --}}
                                    <input class="form-control "type="text" style="display: none;" name='action' value="1">
                                </div>
                                    <button class="receive btn btn-success text-white" type="submit">Confirm</button>
                            </form>
                        </div>
                        @endif

                        <div class="fixIssue" id="fixIssue">
                            <form class="fixIssue" action="fix-issue/{{ $data->referenceNo }}" method="post">
                            @csrf
                                <h6>Confirm Fix</h6>
                                <div class="mb-3">
                                </div>
                                <div class="mb-3">
                                    {{-- <input type="text"  style="display:none;" class="form-control" name="receiverOffice" value="{{ Auth::user()->assignedOffice }}"> --}}
                                    <input class="form-control "type="text" style="display: none;" name='status' value="1">
                                    <input class="form-control "type="text" style="display: none;" name='action' value="5">
                                </div>
                                    <button class="fixIssue btn btn-success text-white" type="submit">Confirm</button>
                            </form>
                        </div>

                        <div class="sendBack" id="sendBack" style="width: 18rem;">
                            <hr>
                            <form class="sendBack" action="send-back/{{ $data->referenceNo }}" method="post">
                                @csrf
                            <div class="card-body">
                              <h5 class="card-title">Send Back</h5>
                              <h6 class="card-subtitle mb-2 text-muted">Issue:</h6>
                              <textarea class="card-text w-100" name="details" required></textarea>
                              <input class="form-control "type="text" style="display: none;" name='status' value="3">
                              <input class="form-control "type="text" style="display: none;" name='email'
                              @if (isset(Auth::user()->email))
                              value="{{ Auth::user()->email }}"
                              @endif
                              >
                              <button type="submit" class="sendBack btn btn-danger" class="text-white">Send Report</button>
                                </form>
                            </div>
                        </div>

                        @if (isset( Auth::user()->name ))
                        <div class="forward" id="forward">
                            <form class="forward" action="forwarded/{{ $data->referenceNo }}" method="post">
                                @csrf
                                <div class="container col-lg-10">
                                <label for="">Forward to:</label>
                                    <select class="form-control" id="assignedOffice" name="receiverOffice">
                                    <option value="" selected disabled>Select Office
                                        @foreach ($selectOffice as $row)
                                            <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="mb-3">
                                        <input class="form-control "type="text" style="display: none;" name='action' value="2">
                                    </div>
                                <button class="forward" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                        @endif
            <hr>
            <h4>Tracking Information</h4>
            <div class="col-xxs-6 col-xs-4" id="latestTrack">
                    <div>
                        @if ($light->action == 3)
                            <h5>In Circulation...</h5>
                        @elseif( $light->action == 1)
                        {{ $light->created_at->diffForHumans() }}
                            <h5>&nbsp;Received by <i>{{ $light->receiverName }}&nbsp;-&nbsp;<i>{{ $light->officeName }}</i></h5>
                                <li class="">Date Received: <i>{{ date_format($light->created_at,'M d Y h:i A')}}</i></li>
                                @if($light->action == 2)
                                <p><li class="">Status: <i>In Circulation</i></p>
                                @endif
                                @if($light->action == 1)
                                    <p><li class="">Status: <i>Processing...</i></p>
                                        <button type="button" data-toggle="modal" data-target="#exampleModalLong" class="btn btn-primary" style="background:white; color:#1B3FAB;"><strong>Show Tracking</strong></button>
                                @endif
                            @elseif( $light->action == 2)
                        {{ $light->created_at->diffForHumans() }}
                            <h5>&nbsp;Forwarded to <i>{{ $light->receiverName }} &nbsp;-&nbsp; <i>{{ $light->officeName }}</i></i></h5>
                                {{-- <li class="">Forwarded to: <i>{{ $light->officeName }}</i></li> --}}
                                <li class="">Date Forwarded: <i>{{ date_format($light->created_at,'M d Y h:i a')}}</i></li>
                                <li class="">Forwarded by: <b>{{ $light->prevReceiver }}</b> - <i>{{ $lightPrev->officeName }}</i></li>
                                @if($light->action == 2)
                                <p><li class="">Status: <i>In Circulation</i></p>
                                @endif
                                @if($light->action == 1)
                                    <p><li class="">Status: <i>Processing...</i></p>
                                @endif
                                </li>
                                <button type="button" data-toggle="modal" data-target="#exampleModalLong" class="btn btn-primary" style="background:white; color:#1B3FAB;"><strong>Show Tracking</strong></button>
                            @elseif( $light->action == 4)
                            {{ $light->created_at->diffForHumans() }}
                                <h5>Something is wrong...</h5>
                                @if (isset($issue))
                                    <p>Issue Details: {{ $issue->details }}</p>
                                @endif
                            <h5>&nbsp;Sent by <i>{{ $light->receiverName }} &nbsp;-&nbsp; <i>{{ $light->officeName }}</i></i></h5>
                                {{-- <li class="">Forwarded to: <i>{{ $light->officeName }}</i></li> --}}
                                <li class="">Date Forwarded: <i>{{ date_format($light->created_at,'M d Y h:i a')}}</i></li>
                                @if($light->action == 2)
                                <p><li class="">Status: <i>In Circulation</i></p>
                                @endif
                                @if($light->action == 1)
                                    <p><li class="">Status: <i>Processing...</i></p>
                                @endif
                                </li>
                                <button type="button" data-toggle="modal" data-target="#exampleModalLong" class="btn btn-primary" style="background:white; color:#1B3FAB;"><strong>Show Tracking</strong></button>
                                @elseif( $light->action == 5)
                            {{ $light->created_at->diffForHumans() }}
                                <h5>Issue was fixed</h5>
                            <h5>&nbsp;Sent by <i>{{ $light->receiverName }} &nbsp;-&nbsp; <i>{{ $light->officeName }}</i></i></h5>
                                {{-- <li class="">Forwarded to: <i>{{ $light->officeName }}</i></li> --}}
                                <li class="">Date Forwarded: <i>{{ date_format($light->created_at,'M d Y h:i a')}}</i></li>
                                @if($light->action == 2)
                                <p><li class="">Status: <i>In Circulation</i></p>
                                @endif
                                @if($light->action == 1)
                                    <p><li class="">Status: <i>Processing...</i></p>
                                @endif
                                </li>
                                <button type="button" data-toggle="modal" data-target="#exampleModalLong" class="btn btn-primary" style="background:white; color:#1B3FAB;"><strong>Show Tracking</strong></button>
                            @endif
                    </div>
                </div>
            <hr>
    </div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Tracking Information</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- {{ dd($altdata['prev']) }} --}}
            <div class="card col-lg-12" id="tracking">
                @foreach($altdata['prev'] as $key => $prev)
                <ul class="unor list-group list-group-flush">
                <div class="section-header">
                    <li>
                    @if( $altdata['trackings'][$key]->action == 1)
                    <h5><div class="top-arrow center">
                    </div>Received by <i>{{ $altdata['trackings'][$key]->senderName }} - {{ $altdata['trackings'][$key]->officeName }} <p>{{ $altdata['trackings'][$key]->created_at->diffForHumans() }}</p></i></h5>
                        {{-- <li class="">Office: <i>{{ $altdata['trackings'][$key]->officeName }}</i></li> --}}
                        <li class="">Date Received: <i>{{ date_format($altdata['trackings'][$key]->created_at,'M d Y h:i A')}}</i></li>
                        @if($altdata['trackings'][$key]->action == 2)
                        <p><li class="">Status: <i>In Circulation</i></p>
                        @endif
                        @if($altdata['trackings'][$key]->action == 1)
                            <p><li class="">Status: <i>Processing...</i></p>
                        @endif
                    @endif
                    @if (($altdata['prev'][$key])->prevOffice == null)
                    <p>sample</p>
                    @endif
                    @if( $altdata['trackings'][$key]->action == 2)
                    <h5><div class="top-arrow center">
                    </div>Forwarded to <i>{{ $altdata['trackings'][$key]->senderName}} - {{ $altdata['trackings'][$key]->officeName }} <p>{{ $altdata['trackings'][$key]->created_at->diffForHumans() }}</p></i></h5>
                        {{-- <li class="">Forwarded to: <i>{{ $altdata['trackings'][$key]->officeName }}</i></li> --}}
                        <li class="">Date Forwarded: <i>{{ date_format($altdata['trackings'][$key]->created_at,'M d Y h:i a')}}</i></li>
                        <li class="">Forwarded by: <b>{{ $altdata['trackings'][$key]->prevReceiver }}</b> - <i>{{ $altdata['prev'][$key]->officeName }}</i></li>
                        @if($altdata['trackings'][$key]->action == 2)
                        <p><li class="">Status: <i>In Circulation</i></p>
                        @endif
                        @if($altdata['trackings'][$key]->action == 1)
                            <p><li class="">Status: <i>Processing...</i></p>
                        @endif
                        </li>
                    @endif
                    @if( $altdata['trackings'][$key]->action == 4)
                    <h5><div class="top-arrow center">
                    </div>
                        @if (isset($issue))
                            <p style="color:red;">Issue Details: {{ $issue->details }}</p>
                            Issue was reported by <i>{{ $issue->email }} - {{ $altdata['trackings'][$key]->officeName }} <p>{{ $altdata['trackings'][$key]->created_at->diffForHumans() }}</p></i></h5>
                        @endif
                        {{-- <li class="">Office: <i>{{ $altdata['trackings'][$key]->officeName }}</i></li> --}}
                        <li class="">Date Received: <i>{{ date_format($altdata['trackings'][$key]->created_at,'M d Y h:i A')}}</i></li>
                        <p><li class="">Status: <i>Has Issue</i></p>
                    @endif
                    @if( $altdata['trackings'][$key]->action == 5)
                    <h5><div class="top-arrow center">
                    </div>
                        @if (isset($issue))
                            <p style="color:green;">Issue Details: {{ $issue->details }}</p>
                            Issue was fixed by <i>{{ $status->email }} - {{ $altdata['trackings'][$key]->officeName }} <p>{{ $altdata['trackings'][$key]->created_at->diffForHumans() }}</p></i></h5>
                        @endif
                        Issue fixed by <i>{{ $altdata['trackings'][$key]->receiverName }} - {{ $altdata['trackings'][$key]->officeName }} <p>{{ $altdata['trackings'][$key]->created_at->diffForHumans() }}</p></i></h5>
                        {{-- <li class="">Office: <i>{{ $altdata['trackings'][$key]->officeName }}</i></li> --}}
                        <li class="">Date Received: <i>{{ date_format($altdata['trackings'][$key]->created_at,'M d Y h:i A')}}</i></li>
                        @if($altdata['trackings'][$key]->action == 2)
                        <p><li class="">Status: <i>In Circulation</i></p>
                        @endif
                        @if($altdata['trackings'][$key]->action == 1)
                            <p><li class="">Status: <i>Processing...</i></p>
                        @endif
                    @endif
                        </li>
                    </div>
                </ul>
                @endforeach
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    function showSendBack() {
    if (document.getElementById('sendBack')) {
        if (document.getElementById('sendBack').style.display == 'none') {
            document.getElementById('sendBack').style.display = 'block';
            document.getElementById('receive').style.display = 'none';
        }
        else {
            document.getElementById('sendBack').style.display = 'none';
            }
        }
    }

    function showForward() {
    if (document.getElementById('forward')) {
        if (document.getElementById('forward').style.display == 'none') {
            document.getElementById('forward').style.display = 'block';
        }
        else {
            document.getElementById('forward').style.display = 'none';
            }
        }
    }

    function fixIssue() {
    if (document.getElementById('fixIssue')) {
        if (document.getElementById('fixIssue').style.display == 'none') {
            document.getElementById('fixIssue').style.display = 'block';
        }
        else {
            document.getElementById('fixIssue').style.display = 'none';
            }
        }
    }

    function showReceive() {
    if (document.getElementById('receive')) {
        if (document.getElementById('receive').style.display == 'none') {
            document.getElementById('receive').style.display = 'block';
            document.getElementById('sendBack').style.display = 'none';
        }
        else {
            document.getElementById('receive').style.display = 'none';
            }
        }
    }

  </script>
  <script type="text/javascript">
    (function(){
    $('.receive').on('submit', function(){
        $('.receive').attr('disabled','true');
        $('.spinner').show();
    })
    })();
    </script>
    <script type="text/javascript">
        (function(){
        $('.forward').on('submit', function(){
            $('.forward').attr('disabled','true');
            $('.forward').show();
        })
        })();
        </script>

        <script type="text/javascript">
        (function(){
        $('.fixIssue').on('submit', function(){
            $('.fixIssue').attr('disabled','true');
            $('.fixIssue').show();
        })
        })();
        </script>

        <script type="text/javascript">
        (function(){
        $('.sendBack').on('submit', function(){
            $('.sendBack').attr('disabled','true');
            $('.sendBack').show();
        })
        })();
        </script>
    <script>
        $("document").ready(function(){
            setTimeout(function(){
                $("#message").remove();
            }, 4500 );
        });
    </script>
    <script type="text/javascript">
        $('#search').on('keyup',function(){
                    $value=$(this).val();
                    $.ajax({
                    type : 'get',
                    url : '{{URL::to('search')}}',
                    data:{'search':$value},
                    success:function(data){
                    console.log(data);
                    $('tbody').html(data);
                }
            });
        });
    </script>
    <script type="text/javascript">
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
@endsection
