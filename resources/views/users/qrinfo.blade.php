@extends('templates.user')
@section('content')
<head>
    <title>Tracking Information</title>
</head>
<style>
#sendBack {
    display: none;
}
#forward {
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



@media screen and (max-width: 700px) {
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
                <h4 class="card-title">Document Details</h4>
                <hr>
                <div style=" margin: 10px; background-color: #ECECEC; border-radius: 10px;">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm p-2">
                               Reference No
                            </div>
                            <div class="col-sm p-2">
                                <h5>{{$data->referenceNo}}</h5>
                             </div>
                             <div class="col-sm p-2">
                                Document Type
                             </div>
                             @if (isset($docCategory->documentName))
                             <div class="col-sm p-2">
                                <h5>{{$docCategory->documentName}}</h5>
                             </div>
                             @endif
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-3 p-2">
                                From Office
                            </div>
                            <div class="col-8 p-2">
                                <h5 class="text-start">{{$data->officeName}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-3 p-2">
                                Sender
                            </div>
                            <div class="col-8 p-2">
                                <h5 class="text-start">{{$data->senderName}}</h5>
                             </div>
                        </div>
                    </div>
                    </div>
                </div>
                @guest
                    <div class="text-center">
                        <p class="font-italic">Login to receive document</p>
                    </div>
                @endguest

                @auth
                @if (isset($light->senderName) == Auth::user()->name && $light->senderOffice == Auth::user()->assignedOffice)
                    <p class="text-center">You may proceed to forward this document to the next receiver</p>
                    <button type="button" class="btn btn-success" class="text-white" onclick="showForward()">Forward</button>
                    <button type="button" class="btn btn-danger" class="text-white" onclick="showSendBack()">Send Back</button>
                @elseif (isset($light->prevReceiver) !== Auth::user()->name && isset($lightPrev->officeName) !== Auth::user()->assignedOffice)
                    @if($light->action == 3)
                        <button class="btn btn-success" type="submit" onclick="showReceive()">Receive</button>
                    @endif
                    @if($light->action == 2)
                    <hr>
                        <button class="btn btn-success" type="submit" onclick="showReceive()">Receive</button>
                    @endif

                    @if($light->action == 1)
                        <div class="d-flex">
                            <button type="button" class="btn btn-success" class="text-white" onclick="showForward()">Forward</button>
                            <button type="button" class="btn btn-danger" class="text-white" onclick="showSendBack()">Send Back</button>
                        </div>
                    @endif
                        </div>
                @endif
                @endauth
                        @if (isset(Auth::user()->name))
                        <div class="receive" id="receive">
                            <form action="received/{{ $data->referenceNo }}" method="post">
                            @csrf
                                <h6>Confirm Receive</h6>
                                <div class="mb-3">
                                    <input style="display:none;" type="text" class="form-control" name="receiverName" id="name" value="{{ Auth::user()->name }}" aria-label="Name" aria-describedby="name">
                                    @error('receiverName')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    {{-- <input type="text"  style="display:none;" class="form-control" name="receiverOffice" value="{{ Auth::user()->assignedOffice }}"> --}}
                                    <input class="form-control "type="text" style="display: none;" name='action' value="1">
                                </div>
                                    <button class="btn btn-success text-white" type="submit">Confirm</button>
                            </form>
                        </div>
                        @endif

                        <div class="sendBack" id="sendBack" style="width: 18rem;">
                            <hr>
                            <form action="send-back/{{ $data->referenceNo }}" method="post">
                                @csrf
                            <div class="card-body">
                              <h5 class="card-title">Send Back</h5>
                              <h6 class="card-subtitle mb-2 text-muted">Issue:</h6>
                              <textarea class="card-text w-100" name="details"></textarea>
                              <input class="form-control "type="text" style="display: none;" name='status' value="3">
                              <button type="submit" class="btn btn-danger" class="text-white">Send Report</button>
                                </form>
                            </div>
                        </div>

                        @if (isset( Auth::user()->name ))
                        <div class="forward" id="forward">
                            <form action="forwarded/{{ $data->referenceNo }}" method="post">
                                @csrf
                                <div class="container col-lg-10">
                                <label for="">Forward to:</label>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="receiverName" id="name" value="{{ $data->receiverName }}"aria-label="Name" aria-describedby="name">
                                        <input type="text" class="form-control" style="display: none;" name="senderName" id="name" value="{{ Auth::user()->name }}"aria-label="Name" aria-describedby="name">
                                        <input type="text" class="form-control" style="display: none;" name="senderOffice" id="name" value="{{ Auth::user()->assignedOffice }}"aria-label="Name" aria-describedby="name">
                                        @error('receiverName')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Current Office Receiver</label>
                                        <input class="form-control" type="text" value="{{ $officeN->officeName }}" disabled>
                                        <label for="">Forward Office</label>
                                        <select class="form-control" id="assignedOffice" name="receiverOffice">
                                            <option value="" selected disabled>Select Office
                                                @foreach ($offices as $row)
                                                <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                                            </option>
                                            @endforeach
                                        </select>

                                        <input class="form-control "type="text" style="display: none;" name='action' value="2">
                                    </div>
                                <button type="submit">Submit</button>
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
                            @endif
                    </div>
            </div>
            <hr>
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
                @if (count($comments) >= 5)
                <div class="btn-group w-100 rounded">
                <button type="button" class="btn dropdown-toggle" style="border-right-radius: 20px;font-weight: bold; background-color: #0275d8; color:white;" data-bs-toggle="dropdown" aria-expanded="false">
                   Show all comments
                </button>
                <ul class="dropdown-menu p-2 w-100">
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
                                        <span class="bg-gray-300 p-2 mb-2 rounded-circle"><strong>{{ $initials }}</strong></span>
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
              @endif
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
            <div class="card col-lg-12" id="tracking">
                @foreach($altdata['prev'] as $key => $prev)
                <ul class="unor list-group list-group-flush">
                <div class="section-header">
                    <li>
                    @if( $altdata['trackings'][$key]->action == 1)
                    <h5><div class="top-arrow center">
                    </div>Received by <i>{{ $altdata['trackings'][$key]->receiverName }} - {{ $altdata['trackings'][$key]->officeName }} <p>{{ $altdata['trackings'][$key]->created_at->diffForHumans() }}</p></i></h5>
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
                    </div>Forwarded to <i>{{ $altdata['trackings'][$key]->receiverName }} - {{ $altdata['trackings'][$key]->officeName }} <p>{{ $altdata['trackings'][$key]->created_at->diffForHumans() }}</p></i></h5>
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
    <script>
    $("document").ready(function(){
        setTimeout(function(){
            $("#message").remove();
        }, 4500 );
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
@endsection
