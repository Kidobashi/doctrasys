@extends('templates.user')
@section('content')
<head>
    <title>Tracking Information</title>
</head>
<style>

.fa-spin.spin-reverse{
    -webkit-animation-direction:reverse;
     -moz-animation-direction:reverse;
    animation-direction:reverse;
}

.gray-circle {
    position: absolute;
    top: 0;
    left: -3px;
    transform: translate(-50%, -50%);
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(65deg, #98a3b3, #6c757d);
    box-shadow: -10px -10px 20px #d9d9d9, 10px 10px 20px #ffffff;
}
.blue-circle {
    position: absolute;
    top: 0;
    left: -3px;
    transform: translate(-50%, -50%);
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(65deg, #0d6efd, #0d48a1);
    box-shadow: -10px -10px 20px #d9d9d9, 10px 10px 20px #ffffff;
}

.red-circle {
    position: absolute;
    top: 0;
    left: -3px;
    transform: translate(-50%, -50%);
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(65deg, #d6402c, #dc3545);
    box-shadow: -10px -10px 20px #d9d9d9, 10px 10px 20px #ffffff;
}
.green-circle {
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
                <h2>Action</h2>
                @if ($status->status == 1 || $status->status == 4)
                <div class="neomorphic-bg d-flex justify-content-center">
                {{-- Received Status --}}
                    <form class="receive" action="received/{{ $data->referenceNo }}" method="post">
                        @csrf
                        <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                        <input class="form-control "type="text" style="display: none;" name='status' value="2">
                        <input class="form-control "type="text" style="display: none;" name='action' value="2">
                        <button class="neo-btn btn" type="submit"><h3>Receive</h3></button>
                    </form>
                </div>
                @elseif ($status->status == 2)
                {{-- Process Status --}}
                <div class="neomorphic-bg d-flex justify-content-center">
                    <form action="process/{{ $data->referenceNo }}" method="post">
                        @csrf
                        <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                        <input type="text" style="display: none;" value="3" name="status">
                        <input type="text" style="display: none;" value="3" name="action">
                        <button type="submit" class="neo-btn btn" onclick=""><h3>Process</h3></button>
                    </form>
                </div>
                    @elseif ($status->status == 3)
                {{-- Return/Forward --}}
                    <div class="text-center justify-content-center">
                        <div class="">
                            <div class="neomorphic-bg text-center">
                                <form action="rejected/{{ $data->referenceNo }}" method="post">
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
                                    <input class="form-control "type="text" style="display: none;" name='receiverOffice_id' value="{{ $getDocumentCreator->senderOffice_id }}">
                                    <input class="form-control "type="text" style="display: none;" name='status' value="5">
                                    <input class="form-control "type="text" style="display: none;" name='action' value="5">
                                    <button class="red-neo-btn btn mt-2 text-white" type="submit"><h6>Submit</h6></button>
                                </form>
                            </div>
                        </div>

                        <div class="mt-2">
                            <div class="neomorphic-bg text-center">
                                <form class="" action="forward/{{ $data->referenceNo }}" method="post">
                                    @csrf
                                    <h6>Forward Document to next the Office</h6>
                                        <select class="form-control text-center" id="assignedOffice" name="receiverOffice">
                                        <option value="" selected disabled>Select Office
                                        @foreach ($selectOffice as $row)
                                            <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                                            </option>
                                        @endforeach
                                        </select>
                                        <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                        <input class="form-control "type="text" style="display: none;" name='action' value="4">
                                        <input class="form-control "type="text" style="display: none;" name='status' value="4">
                                        <button class="neo-btn btn mt-2" type="submit"><h3>Submit</h3></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @elseif ($status->status == 4)
                        {{-- Forward Form Status = 4 --}}
                        <div class="neomorphic-bg text-center">

                        </div>
                        @elseif ($status->status == 5)
                        <div class="neomorphic-bg text-center">
                            <form class="receive" action="return-to-sender/{{ $data->referenceNo }}" method="post">
                                @csrf
                                <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                <input class="form-control "type="text" style="display: none;" name='status' value="6">
                                <input class="form-control "type="text" style="display: none;" name='action' value="6">
                                <button class="neo-btn btn p-auto" type="submit"><h5>Return to Sender</h5></button>
                            </form>
                        </div>
                        @elseif ($status->status == 6)
                        {{-- Report = 6 --}}
                        <div class="neomorphic-bg text-center">
                            <form class="receive" action="resubmit/{{ $data->referenceNo }}" method="post">
                                @csrf
                                <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                <input class="form-control "type="text" style="display: none;" name='status' value="1">
                                <input class="form-control "type="text" style="display: none;" name='action' value="1">
                                <button class="neo-btn btn p-auto" type="submit"><h3>Resubmit</h3></button>
                            </form>
                        </div>
                        @elseif ($status->status == 7)
                        {{-- Report = 7 --}}
                        <div class="neomorphic-bg text-center">

                        </div>
                        @elseif ($status->status == 8)
                        {{-- Report = 8 --}}
                        <div class="neomorphic-bg text-center">

                        </div>
                        @elseif ($status->status == 9)
                        {{-- Report = 9 --}}
                        <div class="neomorphic-bg text-center">

                        </div>
                        @endif
            </div>

            {{-- Tracking Portion --}}
            <div class="col-md-9 col-sm-7">
                <!-- 80% width on desktop, 50% width on mobile -->
                <h2>History</h2>
                    @if (isset($latestTracking->status))
                        @if ( $latestTracking->status == 1 )
                        <div class="d-flex neomorphic-bg justify-content-between">
                            <div class="py-4 m-auto">
                                <div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div style="border-radius: 20px;">
                                            <i class="fas fa-flag fa-4x p-2  text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 neomorphic-bg text-center p-auto">
                                <h2>Created</h2>
                                <p class="p-0 m-0"><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p class="p-0 m-0">{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                        </div>
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
                                <div class="col-md-12 my-4  ml-3" style="position: relative; border-left: 5px solid #0d6efd; height: 8rem;">
                                    <div class="blue-circle">
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
                                            <i class="fas fa-spinner fa-spin fa-4x p-2 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-auto" style="width:40px;">
                                <div class="col-md-12 my-4 ml-3" style="position: relative; border-left: 5px solid #6c757d; height: 8rem;">
                                    <div class="gray-circle">
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
                                            <i class="fas fa-envelope fa-4x p-2" style="color: #28a745;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-auto" style="width:40px;">
                                <div class="col-md-12 my-4  ml-3" style="position: relative; border-left: 5px solid #28a745; height: 8rem;">
                                    <div class="green-circle">
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
                                <div class="col-md-12 my-4  ml-3" style="position: relative; border-left: 5px solid #dc3545; height: 8rem;">
                                    <div class="red-circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg bg-danger">
                                <div class="col-md-3 p-auto bg-white" style="border-radius: 10px;">
                                    <h5 class="text-danger text-center"><strong>REJECTED</strong></h5>
                                </div>
                                <div class="row">
                                    <div class="d-flex flex-wrap">
                                        <p class="m-0 p-0 text-white">Primary Reason of Return: <strong>{{ $primaryIssue->reason }}</strong></p>
                                    </div>
                                </div>
                                @if (isset($boxArray))
                                <div class="row">
                                    <div class="d-flex flex-wrap mb-0">
                                    <p class="text-white">Missing Documents: </p>
                                    @foreach ($boxArray as $item)
                                        @foreach ($item as $value)
                                            <p class="m-0 p-0 text-white"><strong>&nbsp; {{ $value }} &nbsp;</strong></p>
                                        @endforeach
                                    @endforeach
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="d-flex flex-wrap">
                                        <p class="m-0 p-0 text-white">More Details: <strong>{{ $documentWithIssue->others }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif( $latestTracking->status == 6 )<div class="d-flex neomorphic-bg justify-content-between" style="background-color: #dbdde6">
                            <div class="m-auto text-center">
                                <p><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p>{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="py-4 m-auto">
                                <div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div style="border-radius: 20px; background-color: white;">
                                            <i class="fas fa-undo fa-spin spin-reverse fa-4x p-2 text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-auto" style="width:40px;">
                                <div class="col-md-12 my-4 ml-3" style="position: relative; border-left: 5px solid #6c757d; height: 8rem;">
                                    <div class="gray-circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg p-auto">
                                <h5>Returned to Sender</h5>
                            </div>
                        </div>
                        @endif
                    @elseif (isset($latestTracking->status) === false)
                        <div class="d-flex neomorphic-bg justify-content-between">
                            <div class="py-4 m-auto">
                                <div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div style="border-radius: 20px;">
                                            <i class="fas fa-flag fa-4x p-2  text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 neomorphic-bg text-center p-auto">
                                <h2>Created</h2>
                                <p class="p-0 m-0"><strong>{{ $getDocumentCreator->created_at->format('F j, Y') }}</strong></p>
                                <p class="p-0 m-0">{{ $getDocumentCreator->created_at->format('g:i A') }}</p>
                            </div>
                        </div>
                    @endif
                {{-- HISTORY DIV GOES HERE --}}
                </div>
            </div>
        </div>
    </div>
    @endauth

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
