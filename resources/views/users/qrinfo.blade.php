@extends('templates.user')
@section('content')
<head>
    <title>Tracking Information</title>
</head>
<style>

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
  border-left: 2px solid gray;
  padding-left: 50px;
  padding-top: 0 !important;
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

@media screen and (max-width: 700px) {
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
    <div class="container-fluid col-lg-5">
        <div class="row">
            <div class="col-xxs-6 col-xs-4">
                <h4 class="card-title" style="margin-top: 10px;">Document Details</h4>
                            <hr>
                        <div class="d-flex flex-column" style="display: flex; align-items: center; justify-content: center;">
                            <h5>Reference No.: {{$data->referenceNo}}</h5>
                            <h5>Sender: {{$data->senderName}}</h5>

                            <h5>From Office: {{$data->officeName}}</h5>

                            @if($light->action == 3)
                            <div class="d-flex">
                                <button type="button" class="btn btn-secondary" style="margin-right:20px;" disabled><a href="{{ url('forward/'.$data->referenceNo) }}">Forward</a></button>
                                <form action="received/{{ $data->referenceNo }}" method="post">
                                    @csrf
                                    <div class="col-lg-10 float-end" style="display: none;">
                                    {{-- <H1>Receive</H1> --}}
                                    <label for="">Received By:</label>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="receiverName" id="name" value="{{ Auth::user()->name }}"aria-label="Name" aria-describedby="name">
                                            @error('receiverName')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="receiverOffice" value="{{ Auth::user()->assignedOffice }}">

                                            <input class="form-control "type="text" style="display: none;" name='action' value="1">
                                            </div>
                                        {{-- <button type="submit">Receive</button> --}}
                                    </div>
                                    <button type="submit">Receive</button>
                                </form>
                            </div>
                            @endif
                            @if($light->action == 2)
                            <div class="d-flex">
                                {{-- <button type="button" class="btn btn-secondary"  style="margin-right:20px;" disabled><a href="{{ url('forward/'.$data->referenceNo) }}">Forward</a></button> --}}
                                <form action="received/{{ $data->referenceNo }}" method="post">
                                    @csrf
                                    <div class="col-lg-10 float-end" style="display: none;">
                                    {{-- <H1>Receive</H1> --}}
                                    <label for="">Received By:</label>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="receiverName" id="name" value="{{ Auth::user()->name }}"aria-label="Name" aria-describedby="name">
                                            @error('receiverName')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="receiverOffice" value="{{ Auth::user()->assignedOffice }}">

                                            <input class="form-control "type="text" style="display: none;" name='action' value="1">
                                            </div>
                                        {{-- <button type="submit">Receive</button> --}}
                                    </div>
                                    <button type="submit">Receive</button>
                                </form>
                            </div>
                            @endif
                            @if($light->action == 1)
                            <div class="d-flex">
                                <button type="button" class="btn btn-success"><a href="{{ url('forward/'.$data->referenceNo) }}">Forward</a></button>
                                {{-- <button type="button" class="btn btn-success" disabled><a href="{{ url('receive/'.$data->referenceNo) }}" disabled>Receive</a></button> --}}
                            </div>
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
                            <h5>&nbsp;Received by <i>{{ $light->receiverName }}&nbsp;-&nbsp;<i>{{ $light->officeName }}</i></h5>
                                {{-- <li class="">Office: <i>{{ $light->officeName }}</i></li> --}}
                                <li class="">Date Received: <i>{{ date_format($light->created_at,'M d Y h:i A')}}</i></li>
                                @if($light->action == 2)
                                <p><li class="">Status: <i>In Circulation</i></p>
                                @endif
                                @if($light->action == 1)
                                    <p><li class="">Status: <i>Processing...</i></p>
                                        <button type="button" data-toggle="modal" data-target="#exampleModalLong" class="btn btn-primary" style="background:white; color:#1B3FAB;"><strong>Show Tracking</strong></button>
                                @endif
                            {{-- @endif --}}
                            @elseif( $light->action == 2)
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
                            @endif
                    </div>
            </div>
            @include('partials.comments')
            <div class="justify-content-center">
                @foreach ($latestComments as $latestComment)
                <div class="comments m-1 bg-white p-2" style="white-space: normal;">
                    <div class="d-flex">
                        <div class="m-1 d-flex flex-col justify-center">
                            <div>
                                <?php
                                    $parts = explode(' ', $latestComment->author);
                                    $initials = strtoupper($parts[0][0] . $parts[count($parts) - 1][0]);
                                ?>
                                <span class="bg-gray-300 p-2 mb-1 rounded-circle"><strong>{{ $initials }}</strong></span>
                                <span class="mr-1 text-black-200" style="position:relative; right: 0px;">{{  $latestComment->author   }}</span>
                            </div>
                        </div>
                        <div class="d-flex float-end" style="position: absolute; right:0;">
                            <span class="text-black-200" style="font-family: Helvetica, sans-serif; font-size:13px">{{ $latestComment->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <p style="word-wrap: break-word;">{{ $latestComment->text }}</p>
                        <hr>
                </div>
                @endforeach
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Show all comments
                </button>
                <ul class="dropdown-menu">
                  <li>
                    @foreach ($comments as $comment)
                        <div class="comments m-1 bg-white p-2 w-80" style="white-space: normal;">
                            <div class="d-flex">
                                <div class="m-1 d-flex flex-col justify-center">
                                    <div>
                                        <?php
                                            $parts = explode(' ', $comment->author);
                                            $initials = strtoupper($parts[0][0] . $parts[count($parts) - 1][0]);
                                        ?>
                                        <span class="bg-gray-300 p-2 mb-1 rounded-circle"><strong>{{ $initials }}</strong></span>
                                        <span class="mr-1 text-black-200" style="position:relative; right: 0px;">{{  $comment->author   }}</span>
                                    </div>
                                </div>
                                <div class="d-flex float-end" style="position: absolute; right:0;">
                                    <span class="text-black-200" style="font-family: Helvetica, sans-serif; font-size:13px">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                                <p style="word-wrap: break-word;">{{ $comment->text }}</p>
                                <hr>
                        </div>
                    @endforeach
                  </li>
                </ul>
              </div>
        </div>
        {{-- <footer>
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
        </footer> --}}
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
            <div class="card mt-4 col-lg-12" style="border-radius: 0px 6px 6px 0px;" id="tracking">
                @foreach($altdata['prev'] as $key => $prev)
                <ul class="unor list-group list-group-flush">
                <div class="section-header">
                    <li>
                    @if( $altdata['trackings'][$key]->action == 1)
                    <h5><div class="top-arrow center">
                    </div>Received by <i>{{ $altdata['trackings'][$key]->receiverName }} - {{ $altdata['trackings'][$key]->officeName }}</i></h5>
                        {{-- <li class="">Office: <i>{{ $altdata['trackings'][$key]->officeName }}</i></li> --}}
                        <li class="">Date Received: <i>{{ date_format($altdata['trackings'][$key]->created_at,'M d Y h:i A')}}</i></li>
                        @if($altdata['trackings'][$key]->action == 2)
                        <p><li class="">Status: <i>In Circulation</i></p>
                        @endif
                        @if($altdata['trackings'][$key]->action == 1)
                            <p><li class="">Status: <i>Processing...</i></p>
                        @endif
                    @endif
                    @if( $altdata['trackings'][$key]->action == 2)
                    <h5><div class="top-arrow center">
                    </div>Forwarded to <i>{{ $altdata['trackings'][$key]->receiverName }} - {{ $altdata['trackings'][$key]->officeName }}</i></h5>
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


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
@endsection
