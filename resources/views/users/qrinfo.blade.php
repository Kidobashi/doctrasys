@extends('templates.user')
@section('content')
<head>
    <title>Tracking Information</title>
</head>
<style>
 .indicator {

 }
.circle {
  position: absolute;
  top: 0;
  left: -3px;
  transform: translate(-50%, -50%);
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: linear-gradient(65deg, #89e981, #28a745);
  box-shadow: -10px -10px 20px #d9d9d9, 10px 10px 20px #ffffff;
}
.neo-btn {
    padding-top: 10px;
    background-color: #ffffff;
    border: 1px solid #cccccc;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    color: #333333;
    text-align: center;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease-in-out;
}

.red-neo-btn {
    padding-top: 10px;
    background-color: #dc3545;
    border: 1px solid #cccccc;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    color: #333333;
    text-align: center;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease-in-out;
}

.red-neo-btn:hover
{
    background-color: black;
    border-color: #bbbbbb;
    color: #f94449;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.2);
}
.neo-btn:hover
{
    background-color: black;
    border-color: #bbbbbb;
    color: #ffffff;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.2);
}

.neo-btn:focus {
  outline: none;
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

.docDetails {
    margin-top: 10px;
}

@media screen and (max-width: 700px) {

.tracking-margin{
    margin-top: 15px;
}

.vl{
    display: none;
}
.highlights {
    margin: 2px;
}

.docDetails h3{
    font-size: 1rem;
}
.docDetails {
    display:flex;
    flex-direction: column;
}

.docDetails h2 {
    font-size: 16px;
}

.docDetails h1{
    font-size: 18px;
    font-weight: 800;
}

.docDetails p{
    font-size: 12px;
}

.vl {
    border: 1px solid gray;
    width: 100%;
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
This page took {{ number_format((microtime(true) - LARAVEL_START),3)}} seconds to render
<div class="col-md-12 d-flex justify-content-center">
    <div class="col-md-8 row py-4 mx-auto neomorphic-bg" style="border-radius:20px; border:1px solid #d3d3d3;">
        <h2 class="text-center">Document Details</h2>
        <div class="docDetails mt-2 m-0 p-0">
            <div class="d-inline highlights col-md-4 text-center m-0 p-0">
                <p>Reference Number</p>
                @if (isset($data->referenceNo))
                    <h3>{{ $data->referenceNo }}</h3>
                @endif
            </div>
            <div class="vl">
            </div>
            <div class="d-inline highlights col-md-4 text-center m-0 p-0">
                <p>Document Type</p>
                <h3>
                    @if (isset($docCategory->documentName))
                        {{ $docCategory->documentName }}
                    @endif
                </h3>
            </div>
            <div class="vl">
            </div>
            <div class="d-inline highlights col-md-4 text-center m-0 p-0">
                <p>From</p>
                @if (isset($data->officeName))
                    <h3>{{ $data->officeName }}</h3>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="col-8 mx-auto">
    @guest
    <div class="col-md-6 mx-auto text-center neomorphic-bg">
        <h3 class="font-italic">Login to modify document</h3>
    </div>
@endguest
</div>
    @auth
    <div class="col-md-8 mx-auto p-3" style="border-radius: 20px;">
        <div class="row" style="justify-content: space-between;">
            <div class="col-md-3 col-sm-5">
                @if ($status->status == 1)
                <div class="neomorphic-bg d-flex justify-content-center">
                {{-- Received Status --}}
                    <form class="receive" action="received/{{ $data->referenceNo }}" method="post">
                        @csrf
                        <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                        <input class="form-control "type="text" style="display: none;" name='status' value="2">
                        <input class="form-control "type="text" style="display: none;" name='action' value="2">
                        <button class="neo-btn btn" type="submit"><h2>Receive</h2></button>
                    </form>
                </div>
                @elseif ($status->status == 2)
                {{-- Process Status --}}
                    <form action="process/{{ $data->referenceNo }}" method="post">
                        @csrf
                        <input type="text" style="display: none;" value="3" name="status">
                        <input type="text" style="display: none;" value="3" name="action">
                        <button type="submit" class="neo-btn btn" onclick=""><h1>Process</h1></button>
                    </form>
                    @elseif ($status->status == 3)
                {{-- Return/Forward --}}
                    <div class="text-center justify-content-center">
                        <div class="">
                            <div class="neomorphic-bg text-center">
                                <form action="rejected-return/{{ $data->referenceNo }}" method="post">
                                @csrf
                                    <h6>Is something wrong with the document?</h6>
                                    <select class="form-control text-center" id="assignedOffice" name="primary_reason_of_return_id">
                                    <option value="" selected disabled>Select
                                    @foreach ($primaryReason as $row)
                                        <option value="{{ $row->id }}">{{ $row->reason }}</option>
                                        </option>
                                    @endforeach
                                    </select>
                                    @foreach ($lacking as $row)
                                        <div class="m-0 p-0">
                                            <input type="checkbox" name="lacking_doc_id[]" value="{{ $row->name }}">
                                            <label>{{ $row->name }}</label>
                                        </div>
                                    @endforeach
                                    <textarea name="others" id="" cols="30" rows="10" placeholder="others"></textarea>
                                    <input class="form-control "type="text" style="display: none;" name='receiverOffice_id' value="{{ $getDocumentCreator }}">
                                    <input class="form-control "type="text" style="display: none;" name='status' value="5">
                                    <input class="form-control "type="text" style="display: none;" name='action' value="5">
                                    <button class="red-neo-btn btn mt-2 text-white" type="submit"><h6>Submit</h6></button>
                                </form>
                            </div>
                        </div>

                        <div class="mt-2">
                            <div class="neomorphic-bg text-center">
                                <form class="" action="forwarded/{{ $data->referenceNo }}" method="post">
                                    @csrf
                                    <h6>Forward Document to next the Office</h6>
                                        <select class="form-control text-center" id="assignedOffice" name="receiverOffice">
                                        <option value="" selected disabled>Select Office
                                        @foreach ($selectOffice as $row)
                                            <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                                            </option>
                                        @endforeach
                                        </select>
                                        <input class="form-control "type="text" style="display: none;" name='action' value="4">
                                        <input class="form-control "type="text" style="display: none;" name='status' value="4">
                                        <button class="neo-btn px-4 mt-2" type="submit"><h2>Submit</h2></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @elseif ($status->status == 4)
                        {{-- Forward Form Status = 4 --}}

                        @elseif ($status->status == 5)
                        {{-- Report = 5 --}}
                        <div class="neomorphic-bg text-center">

                        </div>
                        @endif
            </div>

            <div class="col-md-9 col-sm-7">
                <!-- 80% width on desktop, 50% width on mobile -->
                <h2>History</h2>
                    @if (isset($latestTracking->status))
                        @if ( $latestTracking->status == 1 )
                            <h1>Status 1</h1>
                        @elseif( $latestTracking->status == 2 )
                        <div class="d-flex neomorphic-bg justify-content-between" style="background-color: #dbdde6">
                            <div class="m-auto text-center">
                                <p><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p>{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="py-4 m-auto">
                                <div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div style="border-radius: 20px; background-color: white;">
                                            <i class="fas fa-check fa-4x p-2 text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-auto" style="width:40px;">
                                <div class="col-md-12 my-4  ml-3" style="position: relative; border-left: 5px solid #28a745; height: 8rem;">
                                    <div class="circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg p-auto">
                                <h5>Received</h5>
                            </div>
                        </div>
                        @elseif( $latestTracking->status == 3 )
                        <div class="d-flex neomorphic-bg justify-content-between" style="background-color: #dbdde6">
                            <div class="m-auto text-center">
                                <p><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p>{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="py-4 m-auto">
                                <div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div style="border-radius: 20px; background-color: white;">
                                            <i class="fas fa-spinner fa-spin fa-4x p-2 text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-auto" style="width:40px;">
                                <div class="col-md-12 my-4  ml-3" style="position: relative; border-left: 5px solid #28a745; height: 8rem;">
                                    <div class="circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg p-auto">
                                <h5>Processing</h5>
                            </div>
                        </div>
                        @elseif( $latestTracking->status == 4 )
                        <div class="d-flex neomorphic-bg justify-content-between" style="background-color: #dbdde6">
                            <div class="m-auto text-center">
                                <p><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p>{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="py-4 m-auto">
                                <div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div style="border-radius: 20px; background-color: white;">
                                            <i class="fas fa-envelope fa-4x p-2  text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-auto" style="width:40px;">
                                <div class="col-md-12 my-4  ml-3" style="position: relative; border-left: 5px solid #28a745; height: 8rem;">
                                    <div class="circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg p-auto">
                                <h5>Forwarded</h5>
                            </div>
                        </div>
                        @elseif( $latestTracking->status == 5 )
                        <div class="d-flex neomorphic-bg justify-content-between" style="background-color: #dbdde6">
                            <div class="m-auto text-center">
                                <p><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p>{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="py-4 m-auto">
                                <div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div style="border-radius: 20px; background-color: white;">
                                            <i class="fas fa-exclamation-circle fa-4x p-2  text-danger"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-auto" style="width:40px;">
                                <div class="col-md-12 my-4  ml-3" style="position: relative; border-left: 5px solid #28a745; height: 8rem;">
                                    <div class="circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg p-auto">
                                <h5>Has Issue Status 5</h5>
                                @foreach ($boxArray as $item)
                                    @foreach ($item as $value)
                                        <p class="m-0 p-0">{{ $value }}</p>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @elseif (isset($light->action) === false)
                            <h1>Empty</h1>
                    @endif
                {{-- HISTORY DIV GOES HERE --}}
                </div>
            </div>
        </div>
    </div>
    @endauth

    <div class="container col-lg-6">
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
                @if (isset($altdata['trackings'][$key]->action))
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
                @endif
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
  {{-- <script type="text/javascript">
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
        </script> --}}
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
