@extends('templates.user')
@section('content')
<head>
    <title>Tracking Information</title>
</head>
<style>
.icon-sz{
    display: flex;
    justify-content: center;
    align-items: center;
    height:80px;
    width:80px;
}

.alt-icon-sz
{
    display: flex;
    justify-content: center;
    align-items: center;
    height:70px;
    width:70px;
}
/* .icon-sz i{
    position:relative;

} */
.fa-spin.spin-reverse{
    -webkit-animation-direction:reverse;
     -moz-animation-direction:reverse;
    animation-direction:reverse;
}

.latest-tracking-details{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
    padding: auto;
}

.instruction{
    min-width: 430px;
}

.tracking-details{
    margin-left: 16.5px;
    margin-top: 8px;
    margin-bottom: 8px;
}

.dashed-line{
    height: 70px;
    /* width: 0px; */
    border-left: 8px dashed black;
    margin-left:9px;
    margin-top:17.5px;
}

.yellow-circle {
    position: absolute;
    top: 0;
    left: -3px;
    transform: translate(-50%, -50%);
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(65deg, #e2e06b, #f0ad4e);
    box-shadow: -10px -10px 20px #d9d9d9, 10px 10px 20px #ffffff;
}
.gray-circle {
    position: absolute;
    top: 13px;
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
    top: 13px;
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
    top: 13px;
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
  top: 13px;
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
    <div class="col-md-8 mx-auto p-2" style="border-radius: 20px;">
        <div class="row" style="justify-content: space-between;">
            <div class="col-md-3 col-sm-5">
                <h2>Action</h2>
                @if ($status->status == 1)
                <div class="neomorphic-bg d-flex justify-content-center">
                {{-- Received Status --}}
                        Normal Receive
                        <form class="receive" action="received/{{ $data->referenceNo }}" method="post">
                            @csrf
                            <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                            <input class="form-control "type="text" style="display: none;" name='status' value="2">
                            <input class="form-control "type="text" style="display: none;" name='action' value="2">
                            <button class="neo-btn btn" type="submit"><h3>Receive</h3></button>
                        </form>
                </div>
                @elseif ($status->status == 2)
                    @if($latestResultRow->senderOffice == Auth::user()->assignedOffice && Auth::user()->assignedOffice != $status->receiverOffice_id)
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
                    @elseif ($latestResultRow->senderOffice == Auth::user()->assignedOffice && $status->receiverOffice_id == Auth::user()->assignedOffice)
                    <div class="neomorphic-bg">
                    <p class="text-secondary  text-center p-3 pb-0"><em>As the intended receiving office,
                        you have the option to Approve/Reject
                        and/or Return to Sender/Previous Office.</em>
                    </p>
                    <div class="d-flex justify-content-center">
                        {{-- Aprrove/Return to Sender --}}
                                <form id="approved-and-keep-form" action="approved-and-kept/{{ $data->referenceNo }}" method="post">
                                    @csrf
                                    <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                    <input class="form-control "type="text" style="display: none;" name='status' value="9">
                                    <input class="form-control "type="text" style="display: none;" name='action' value="9">
                                    <button class="neo-btn btn" id="approve-and-keep-btn" type="submit"><h5>Approve and Keep</h5></button>
                                </form>
                            </div>
                    <div class="mt-3 d-flex justify-content-center">
                    {{-- Aprrove/Return to Sender --}}
                            <form id="approved-and-return-form" action="approved-and-return/{{ $data->referenceNo }}" method="post">
                                @csrf
                                <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                <input class="form-control "type="text" style="display: none;" name='status' value="2">
                                <input class="form-control "type="text" style="display: none;" name='action' value="2">
                                <button class="neo-btn btn" id="received-by-intended-btn" type="submit"><h5>Approve/Return to Sender</h5></button>
                            </form>
                        </div>
                        <div class="mt-3 d-flex justify-content-center">
                    {{-- Reject/Return to Previous Office --}}
                            <form id="reject-return-to-previous-form" action="reject-return-to-previous/{{ $data->referenceNo }}" method="post">
                                @csrf
                                <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                <input class="form-control "type="text" style="display: none;" name='status' value="2">
                                <input class="form-control "type="text" style="display: none;" name='action' value="2">
                                <button class="neo-btn btn" id="reject-return-to-previous-btn" type="submit"><h5>Reject/Return to Previous Office</h5></button>
                            </form>
                        </div>
                        <div class="mt-3 d-flex justify-content-center">
                        {{-- Reject/Return to Sender --}}
                            <form id="reject-return-to-sender-form" action="reject-return-to-sender/{{ $data->referenceNo }}" method="post">
                                @csrf
                                <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                <input class="form-control "type="text" style="display: none;" name='status' value="2">
                                <input class="form-control "type="text" style="display: none;" name='action' value="2">
                                <button class="neo-btn btn" id="reject-return-to-sender-btn" type="submit"><h5>Reject/Return to Sender</h5></button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="neomorphic-bg d-flex justify-content-center">
                        <p class="text-secondary  text-center p-3 pb-0"><em>Please note that the document you requested is was received by another department.
                            Please allow us some time to complete the processing. Thank you for your patience and understanding.</em>
                        </p>
                    </div>
                    @endif
                @elseif ($status->status == 3)
                    @if($latestTracking->senderOffice == Auth::user()->assignedOffice)
                {{-- Return/Forward --}}
                    <div class="text-center justify-content-center">
                        <div class="">
                            <div class="neomorphic-bg text-center">
                                <form action="rejected/{{ $data->referenceNo }}" method="post">
                                @csrf
                                    <h6>Is something wrong with the document?</h6>
                                    <label for="primary_reason_of_return_id">Choose primary reason of return<span class="required text-danger" style="font-size: 20px;">*</span></label>
                                    <select class="form-control text-center" id="select-reason-reject" name="primary_reason_of_return_id" required>
                                    <option value="" selected disabled>Choose
                                    @foreach ($primaryReason as $row)
                                        <option value="{{ $row->id }}">{{ $row->reason }}</option>
                                        </option>
                                    @endforeach
                                    </select>
                                    @if ($errors->has('primary_reason_of_return_id'))
                                        <span class="text-danger">{{ $errors->first('primary_reason_of_return_id') }}</span>
                                    @endif
                                    @foreach ($lacking as $row)
                                        <div class="m-0 p-0">
                                            <input class="form-check-input"  type="checkbox" id="lacking-checkbox" name="lacking_doc_id[]" value="{{ $row->name }}"  data-value="{{ $row->name }}">
                                            <label>{{ $row->name }}</label>
                                        </div>
                                    @endforeach
                                    <textarea class="form-control" name="others" id="" cols="30" rows="10" placeholder="others"></textarea>
                                    <input class="form-control "type="text" style="display: none;" name='receiverOffice_id' value="{{ $getDocumentCreator->senderOffice_id }}">
                                    <input class="form-control "type="text" style="display: none;" name='senderOffice_id' value="{{ Auth::user()->assignedOffice }}">
                                    <input class="form-control "type="text" style="display: none;" name='status' value="5">
                                    <input class="form-control "type="text" style="display: none;" name='action' value="5">
                                    <button class="red-neo-btn btn mt-2 text-white" id="report-btn" type="submit"><h6>Submit</h6></button>
                                </form>
                            </div>
                        </div>

                        <div class="mt-2">
                            <div class="neomorphic-bg text-center">
                                <form class="" action="forward/{{ $data->referenceNo }}" method="post">
                                    @csrf
                                    <h6>Forward Document to next the Office</h6>
                                    <label for="receiverOffice">Select the office to forward<span class="required text-danger" style="font-size: 20px;">*</span></label>
                                        <select class="form-control text-center" id="forward-select" name="receiverOffice" required>
                                        <option value="" selected disabled>Select Office
                                        @foreach ($selectOffice as $row)
                                            <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                                            </option>
                                        @endforeach
                                        </select>
                                        <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                        <input class="form-control "type="text" style="display: none;" name='action' value="4">
                                        <input class="form-control "type="text" style="display: none;" name='status' value="4">
                                        <button class="neo-btn btn mt-2" id="forward-btn" type="submit"><h3>Submit</h3></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="neomorphic-bg d-flex justify-content-center">
                            <p class="text-secondary  text-center p-3 pb-0"><em>Please note that the document you requested is being processed in another department.
                                Please allow us some time to complete the processing. Thank you for your patience and understanding.</em>
                            </p>
                        </div>
                        @endif
                    @elseif ($status->status == 4)
                        {{-- Forward Form Status = 4 --}}
                        <div class="neomorphic-bg text-center">
                            @if ($latestResultRow->receiverOffice == Auth::user()->assignedOffice && $status->receiverOffice_id == $latestResultRow->receiverOffice)
                            <p class="text-secondary  text-center p-3 pb-0"><em>As the intended receiving office,
                                 you have the option to Approve/Reject
                                 and/or Return to Sender/Previous Office.</em>
                            </p>
                            <div class="d-flex justify-content-center">
                                {{-- Aprrove/Return to Sender --}}
                                <form id="received-by-intended-form" action="received-by-intended/{{ $data->referenceNo }}" method="post">
                                    @csrf
                                    <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                    <input class="form-control "type="text" style="display: none;" name='status' value="2">
                                    <input class="form-control "type="text" style="display: none;" name='action' value="2">
                                    <button class="neo-btn btn" id="received-by-intended-btn" type="submit"><h5>Aprrove/Return to Sender</h5></button>
                                </form>
                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                {{-- Reject/Return to Previous Office --}}
                                <form id="reject-return-to-previous-form" action="reject-return-to-previous/{{ $data->referenceNo }}" method="post">
                                    @csrf
                                    <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                    <input class="form-control "type="text" style="display: none;" name='status' value="2">
                                    <input class="form-control "type="text" style="display: none;" name='action' value="2">
                                    <button class="neo-btn btn" id="reject-return-to-previous-btn" type="submit"><h5>Reject/Return to Previous Office</h5></button>
                                </form>
                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                {{-- Reject/Return to Sender --}}
                                    <form id="reject-return-to-sender-form" action="reject-return-to-sender/{{ $data->referenceNo }}" method="post">
                                        @csrf
                                        <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                        <input class="form-control "type="text" style="display: none;" name='status' value="2">
                                        <input class="form-control "type="text" style="display: none;" name='action' value="2">
                                        <button class="neo-btn btn" id="reject-return-to-sender-btn" type="submit"><h5>Reject/Return to Sender</h5></button>
                                    </form>
                                </div>
                            @else
                            <form class="receive" action="received/{{ $data->referenceNo }}" method="post">
                                @csrf
                                    <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                    <input class="form-control "type="text" style="display: none;" name='status' value="2">
                                    <input class="form-control "type="text" style="display: none;" name='action' value="2">
                                    <button class="neo-btn btn" type="submit"><h3>Receive</h3></button>
                                </form>
                            @endif
                        </div>
                        @elseif ($status->status == 5)
                            @if($latestTracking->senderOffice == Auth::user()->assignedOffice)
                                <div class="neomorphic-bg text-center">
                                    <form class="receive" action="return-to-sender/{{ $data->referenceNo }}" method="post">
                                        @csrf
                                        <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                        <input class="form-control "type="text" style="display: none;" name='status' value="6">
                                        <input class="form-control "type="text" style="display: none;" name='action' value="6">
                                        <button class="neo-btn btn p-auto" type="submit"><h5>Return to Sender</h5></button>
                                    </form>
                                </div>
                            @else
                            <div class="neomorphic-bg d-flex justify-content-center">
                                <p class="text-secondary  text-center p-3 pb-0"><em>Please note that the document you requested is being processed in another department.
                                    Please allow us some time to complete the processing. Thank you for your patience and understanding.</em>
                                </p>
                            </div>
                            @endif
                        @elseif ($status->status == 6)
                        {{-- Report = 7 --}}
                        @if($latestTracking->receiverOffice == Auth::user()->assignedOffice)
                        <div class="neomorphic-bg text-center">
                                <form id="resolve-form" action="resolve/{{ $data->referenceNo }}" method="post">
                                    @csrf
                                    <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                    <input class="form-control "type="text" style="display: none;" name='status' value="7">
                                    <input class="form-control "type="text" style="display: none;" name='action' value="7">
                                    <button class="neo-btn btn p-auto" type="submit"><h3>Resolve Issue</h3></button>
                                </form>
                        </div>
                        @else
                            <div class="neomorphic-bg d-flex justify-content-center">
                                <p class="text-secondary  text-center p-3 pb-0"><em>Please note that the document you requested is being resolved by another department.
                                    Please allow us some time to complete the processing. Thank you for your patience and understanding.</em>
                                </p>
                            </div>
                            @endif
                        @elseif ($status->status == 7)
                        {{-- Report = 6 --}}
                        @if ($latestTracking->senderOffice == Auth::user()->assignedOffice)
                            <div class="neomorphic-bg text-center">
                            <form id="resubmit-form" action="resubmit/{{ $data->referenceNo }}" method="post">
                                @csrf
                                <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                <input class="form-control "type="text" style="display: none;" name='status' value="1">
                                <input class="form-control "type="text" style="display: none;" name='action' value="8">
                                <button class="neo-btn btn p-auto" id="resubmit-btn" type="submit" ><h3>Resubmit</h3></button>
                            </form>
                        </div>
                        @else
                            <div class="neomorphic-bg d-flex justify-content-center">
                                <p class="text-secondary  text-center p-3 pb-0"><em>Please note that the document being requested is currerntly being reviewd and recompiled to be resubmitted by another department.
                                    Please allow us some time to complete the processing. Thank you for your patience and understanding.</em>
                                </p>
                            </div>
                            @endif
                        @elseif ($status->status == 8)
                        {{-- Report = 8 --}}
                        {{-- <div class="neomorphic-bg text-center"> --}}
                                {{-- Received Status --}}
                            {{-- <form class="receive" action="received/{{ $data->referenceNo }}" method="post">
                                @csrf
                                <input class="form-control "type="text" style="display: none;" name='senderOffice' value="{{ Auth::user()->assignedOffice }}">
                                <input class="form-control "type="text" style="display: none;" name='status' value="2">
                                <input class="form-control "type="text" style="display: none;" name='action' value="2">
                                <button class="neo-btn btn" type="submit"><h3>Receive</h3></button>
                            </form>
                        </div> --}}
                        @elseif ($status->status == 9)
                        {{-- Report = 9 --}}
                        <div class="neomorphic-bg text-center">
                            <p class="text-secondary  text-center p-3 pb-0"><em>No further modifications will be made.</em>
                            </p>
                        </div>
                        @endif
            </div>
            {{-- Tracking Portion --}}
            <div class="col-md-9 col-sm-7">
                <!-- 80% width on desktop, 50% width on mobile -->
                <h3>Current Status</h3>
                    @if (isset($latestTracking->status))
                        @if ( $latestTracking->status == 1 )
                        <div class="d-flex neomorphic-bg justify-content-between mb-1">
                            <div class="col-md-1 bg-light icon-sz text-center" style="border-radius: 20px;">
                                <i class="fas fa-flag fa-4x text-info"></i>
                            </div>
                            <div class="col-md-10 neomorphic-bg">
                                <div class="col-md-2 p-auto bg-info" style="border-radius: 10px;">
                                    <h5 class="text-dark text-center"><strong>Created</strong></h5>
                                </div>
                                <p class="p-0 m-0">Date Created: <strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong> {{ $latestTracking->created_at->format('g:i A') }}</p>
                                <p class="p-0 m-0">Created by the <strong>{{ $latestTracking->senderOfficeName }}</strong></p>
                            </div>
                        </div>
                        @elseif( $latestTracking->status == 2 )
                        <div class="d-flex neomorphic-bg justify-content-between mb-1" style="background-color: #dbdde6">
                            <div class="col-md-1 m-1 text-center">
                                <p class="m-0 p-0"><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p class="m-0 p-0">{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="col-md-1 bg-light text-center icon-sz" style="border-radius: 20px;">
                                <i class="fas fa-check fa-4x text-primary"></i>
                            </div>
                            <div class="col-md-1" style="width:10px;">
                                <div class="col-md-12" style="position: relative; border-left: 6px solid #0d6efd; height: 95%;">
                                    <div class="blue-circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg bg-primary">
                                <div class="col-md-4 p-auto bg-white" style="border-radius: 10px;">
                                    <h5 class="text-primary text-center"><strong>RECEIVED</strong></h5>
                                </div>
                                <div class="row">
                                    <div class="d-flex flex-wrap">
                                        <p class="m-0 p-0 text-white">This document is currently at the <strong>{{ $latestTracking->senderOfficeName }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif( $latestTracking->status == 3 )
                        <div class="d-flex neomorphic-bg justify-content-between mb-1" style="background-color: #dbdde6">
                            <div class="col-md-1 m-1 text-center">
                                <p class="m-0 p-0"><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p class="m-0 p-0">{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="col-md-1 bg-light text-center icon-sz" style="border-radius: 20px;">
                                <i class="fas fa-spinner fa-spin fa-4x text-secondary"></i>
                            </div>
                            <div class="col-md-1" style="width:10px;">
                                <div class="col-md-12" style="position: relative; border-left: 6px solid #6c757d; height: 95%;">
                                    <div class="gray-circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg bg-secondary">
                                <div class="col-md-4 p-auto bg-white" style="border-radius: 10px;">
                                    <h5 class="text-dark text-center"><strong>Processing</strong></h5>
                                </div>
                                <div class="row">
                                    <div class="d-flex flex-wrap">
                                        <p class="m-0 p-0 text-white">This document is currently being processed at <strong>{{ $latestTracking->senderOfficeName }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif( $latestTracking->status == 4 )
                        <div class="d-flex neomorphic-bg justify-content-between mb-1" style="background-color: #dbdde6">
                            <div class="col-md-1 m-1 text-center">
                                <p class="m-0 p-0"><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p class="m-0 p-0">{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="col-md-1 bg-light text-center icon-sz" style="border-radius: 20px;">
                                <i class="fas fa-envelope fa-4x" style="color: #28a745;"></i>
                            </div>
                            <div class="col-md-1" style="width:10px;">
                                <div class="col-md-12" style="position: relative; border-left: 6px solid #28a745; height: 95%;">
                                    <div class="green-circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg bg-success p-auto">
                                <div class="col-md-4 p-auto bg-white" style="border-radius: 10px;">
                                    <h5 class="text-success text-center"><strong>Forwarded</strong></h5>
                                </div>
                                <div class="row">
                                    <div class="d-flex flex-wrap">
                                        <p class="m-0 p-0 text-white">This document was forwarded by the <strong>{{ $latestTracking->senderOfficeName }}</strong> to the <strong>{{ $latestResultRow->receiverOfficeName }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif( $latestTracking->status == 5 )
                        <div class="d-flex neomorphic-bg justify-content-between mb-1" style="background-color: #dbdde6">
                            <div class="col-md-1 m-1 text-center">
                                <p class="m-0 p-0"><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p class="m-0 p-0">{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="col-md-1 bg-light text-center icon-sz" style="border-radius: 20px;">
                                <i class="fas fa-exclamation-circle fa-4x text-danger"></i>
                            </div>
                            <div class="col-md-1" style="width:10px;">
                                <div class="col-md-12" style="position: relative; border-left: 6px solid #dc3545; height: 95%;">
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
                                        <p class="m-0 p-0 text-white">Rejected by the <strong>{{ $latestTracking->senderOfficeName }}</strong></p>
                                        <p class="m-0 p-0 text-white">Sent back to the <strong>{{ $latestTracking->receiverOfficeName }}</strong></p>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        @if (isset($documentWithIssue))
                                            <p class="m-0 p-0 text-white">Primary Reason of Return: <strong>{{ $documentWithIssue->primary }}</strong></p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex flex-wrap mb-0">
                                @if(isset($boxArray))
                                    @foreach ($boxArray as $item)
                                        @if (!empty($item))
                                        <p class="text-white m-0 p-0">Missing Documents: </p>
                                            @foreach ($item  as $value)
                                            <p class="m-0 p-0 text-white"><strong>&nbsp; {{ $value }} &nbsp;</strong></p>
                                            @endforeach
                                        @endif
                                    @endforeach
                                    </div>
                                @endif
                                </div>
                                <div class="row">
                                    <div class="d-flex flex-wrap">
                                        @if (isset($documentWithIssue->others))
                                            <p class="m-0 p-0 text-white">More Details: <strong>{{ $documentWithIssue->others }}</strong></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif( $latestTracking->status == 6 )
                        <div class="d-flex neomorphic-bg justify-content-between mb-1" style="background-color: #dbdde6">
                            <div class="col-md-1 m-1 text-center">
                                <p class="m-0 p-0"><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p class="m-0 p-0">{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="col-md-1 bg-light text-center icon-sz" style="border-radius: 20px;">
                                <i class="fas fa-undo fa-spin spin-reverse fa-4x text-secondary"></i>
                            </div>
                            <div class="col-md-1" style="width:10px;">
                                <div class="col-md-12" style="position: relative; border-left: 6px solid #6c757d; height: 95%;">
                                    <div class="gray-circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg bg-secondary p-auto">
                                <div class="col-md-8 p-auto bg-white" style="border-radius: 10px;">
                                    <h5 class="px-2 text-secondary text-center"><strong>RETURNED TO PREVIOUS OFFICE</strong></h5>
                                </div>
                                <div class="row">
                                    <div class="d-flex flex-wrap">
                                        <p class="m-0 p-0 text-white">This document is being returned to the <strong>{{ $latestResultRow->receiverOfficeName }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif( $latestTracking->status == 7 )
                        <div class="d-flex neomorphic-bg justify-content-between" style="background-color: #dbdde6">
                            <div class="col-md-1 m-1 text-center">
                                <p class="m-0 p-0"><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p class="m-0 p-0">{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="col-md-1 bg-light text-center icon-sz" style="border-radius: 20px;">
                                <i class="fas fa-tasks fa-4x text-warning"></i>
                            </div>
                            <div class="col-md-1" style="width:10px;">
                                <div class="col-md-12" style="position: relative; border-left: 6px solid #f0ad4e; height: 95%;">
                                    <div class="yellow-circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg bg-warning">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-md-5 bg-white mb-2" style="border-radius: 8px; margin-left: 10px;">
                                        <h5 class="text-warning text-center mb-0"><strong>RESOLVING ISSUE</strong></h5>
                                    </div>
                                    <div class="col-md-2 btn-group dropleft">
                                        <button type="button" class="btn btn-dark badge" data-toggle="dropdown">
                                            <strong>Instruction</strong>
                                        </button>
                                        <div class="dropdown-menu">
                                              <!-- Dropdown menu links -->
                                            <div class="d-flex flex-wrap bg-white p-3 instruction" style="border-radius: 10px; font-size: 12px;">
                                                <p>To properly resubmit the document, follow these steps:</p>
                                                <p>1. <strong>Complete the missing requirements</strong>.</p>
                                                <p>2. <strong>Reevaluate and recompile</strong> if necessary.<p>
                                                <p>3. Conduct a <strong>double check.</strong></p>
                                                <p class="mb-3">4. Proceed to <strong>resubmit</strong> the document.</p>
                                                <p><em><strong>Note that only the creator (office) of the document has the authority to resolve any issues and resubmit the document.</strong></em></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 p-1 mt-2 px-auto bg-white" style="border-radius: 8px;">
                                    <div class="d-flex flex-wrap">
                                        <p class="m-0 p-0">Being Resolved by the<strong>{{ $latestTracking->senderOfficeName }}</strong></p>
                                        <p class="m-0 p-0 text-black">Primary Reason of Return: <strong>{{ $documentWithIssue->primary }}</strong></p>
                                    </div>
                                    <div class="row">
                                        <div class="d-flex flex-wrap mb-0">
                                    @if(isset($boxArray))
                                        @foreach ($boxArray as $item)
                                            @if (!empty($item))
                                            <p class="m-0 p-0">Missing Documents: </p>
                                                @foreach ($item  as $value)
                                                <p class="m-0 p-0"><strong>&nbsp; {{ $value }} &nbsp;</strong></p>
                                                @endforeach
                                            @endif
                                        @endforeach
                                        </div>
                                        @endif
                                    </div>
                                     <div class="d-flex flex-wrap">
                                        @if (isset($documentWithIssue->others))
                                            <p class="m-0 p-0 text-black" style="font-size: 1em;">More Details: <strong>{{ $documentWithIssue->others }}</strong></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif( $latestTracking->status == 8 )
                        <div class="d-flex neomorphic-bg justify-content-between p-auto" style="background-color: #dbdde6; ">
                            <div class="col-md-1 m-1 text-center">
                                <p class="m-0 p-0"><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p class="m-0 p-0">{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="col-md-1 bg-light text-center icon-sz" style="border-radius: 20px;">
                                <i class="fas fa-check-double fa-4x text-primary"></i>
                            </div>
                            <div class="col-md-1" style="width:10px;">
                                <div class="col-md-12" style="position: relative; border-left: 6px solid #0d6efd; height: 95%;">
                                    <div class="blue-circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg bg-primary p-auto">
                                <div class="col-md-5 p-auto bg-white" style="border-radius: 10px;">
                                    <h5 class="text-black text-center"><strong>RESUBMITTED</strong></h5>
                                </div>
                                <div class="row">
                                    <div class="d-flex flex-wrap">
                                        <p class="m-0 p-0 text-white">Resubmitted by <strong>{{ $latestResultRow->senderOfficeName }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($latestTracking->status == 9)
                        <div class="d-flex neomorphic-bg justify-content-between mb-1" style="background-color: #dbdde6">
                            <div class="col-md-1 m-1 text-center">
                                <p class="m-0 p-0"><strong>{{ $latestTracking->created_at->format('F j, Y') }}</strong></p>
                                <p class="m-0 p-0">{{ $latestTracking->created_at->format('g:i A') }}</p>
                            </div>
                            <div class="col-md-1 bg-light text-center icon-sz" style="border-radius: 20px;">
                                <i class="fas fa-lock fa-4x text-success"></i>
                            </div>
                            <div class="col-md-1" style="width:10px;">
                                <div class="col-md-12" style="position: relative; border-left: 6px solid #28a745; height: 95%;">
                                    <div class="green-circle">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 neomorphic-bg bg-success">
                                <div class="col-md-4 p-auto bg-white" style="border-radius: 10px;">
                                    <h5 class="text-success text-center"><strong>RECEIVED</strong></h5>
                                </div>
                                <div class="row">
                                    <div class="d-flex flex-wrap">
                                        <p class="m-0 p-0 text-white"><em>"The document has been received and tagged by the intended office
                                            <strong>({{ $latestTracking->senderOfficeName }})</strong>, indicating that it has reached its
                                            final state in the life cycle and is now permanently stored.
                                            No further modifications can be made to the document."
                                        </em></p>
                                    </div>
                                </div>
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
                    <h3 class="m-2">History</h3>
                    @foreach ($trackingHistory as $row)
                        @if ($row->status == 1)
                            <div class="d-flex">
                                <div class="col-md-3 p-2 m-2 neomorphic-bg text-center d-flex">
                                    <div class="col-md-4 neomorphic-bg bg-info alt-icon-sz">
                                        <i class="fas fa-flag fa-2x text-white"></i>
                                    </div>
                                    <div class="col-md-7">
                                        <p class="m-auto pt-3">{{ $row->created_at->format('F j, Y') }} {{ $row->created_at->format('g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="dashed-line">
                                </div>
                                <div class="col-md-7 tracking-details neomorphic-bg">
                                    <p class="m-0 p-0">Initiated by <strong>{{ $row->senderOfficeName }}</strong></p>
                                </div>
                            </div>
                        @elseif ($row->status == 2)
                            <div class="d-flex">
                                <div class="col-md-3 p-2 m-2 neomorphic-bg text-center d-flex">
                                    <div class="col-md-4 neomorphic-bg alt-icon-sz bg-primary">
                                        <i class="fas fa-check fa-2x text-white"></i>
                                    </div>
                                    <div class="col-md-7">
                                        <p class="m-auto pt-3">{{ $row->created_at->format('F j, Y') }} {{ $row->created_at->format('g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="dashed-line">
                                </div>
                                <div class="col-md-7 tracking-details neomorphic-bg">
                                    <p>Received by <strong>{{ $row->senderOfficeName }}</strong></p>
                                </div>
                            </div>
                        @elseif ($row->status == 3)
                            <div class="d-flex">
                                <div class="col-md-3 p-2 m-2 neomorphic-bg text-center d-flex">
                                    <div class="col-md-4 neomorphic-bg bg-secondary alt-icon-sz">
                                        <i class="fas fa-spinner fa-spin fa-2x text-white"></i>
                                    </div>
                                    <div class="col-md-7">
                                        <p class="m-auto pt-3">{{ $row->created_at->format('F j, Y') }} {{ $row->created_at->format('g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="dashed-line">
                                </div>
                                <div class="col-md-7 tracking-details neomorphic-bg">
                                    <p>Processed by <strong>{{ $row->senderOfficeName }}</strong></p>
                                </div>
                            </div>
                        @elseif ($row->status == 4)
                            <div class="d-flex">
                                <div class="col-md-3 p-2 m-2 neomorphic-bg text-center d-flex">
                                    <div class="col-md-4 neomorphic-bg bg-success alt-icon-sz">
                                        <i class="fas fa-envelope fa-2x text-white"></i>
                                    </div>
                                    <div class="col-md-7">
                                        <p class="m-auto pt-3">{{ $row->created_at->format('F j, Y') }} {{ $row->created_at->format('g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="dashed-line">
                                </div>
                                <div class="col-md-7 tracking-details neomorphic-bg">
                                    <p>Forwarded by the <strong>{{ $row->senderOfficeName }}</strong></p>
                                </div>
                            </div>
                        @elseif ($row->status == 5)
                            <div class="d-flex">
                                <div class="col-md-3 p-2 m-2 neomorphic-bg text-center d-flex">
                                    <div class="col-md-4 neomorphic-bg bg-danger alt-icon-sz">
                                        <i class="fas fa-exclamation-circle fa-2x text-white"></i>
                                    </div>
                                    <div class="col-md-7">
                                        <p class="m-auto pt-3">{{ $row->created_at->format('F j, Y') }} {{ $row->created_at->format('g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="dashed-line">
                                </div>
                                <div class="col-md-7 tracking-details neomorphic-bg">
                                    <p class="m-0">Reported by <strong>{{ $row->senderOfficeName }}</strong></p>
                                    @if (isset($boxArray))
                                    <div class="row">
                                        <div class="d-flex flex-wrap mb-0">
                                        <p class="text-black m-0">Missing Documents: </p>
                                        @foreach ($boxArray as $item)
                                            @foreach ($item as $value)
                                                <p class="m-0 p-0 text-black"><strong>&nbsp; {{ $value }} &nbsp;</strong></p>
                                            @endforeach
                                        @endforeach
                                        </div>
                                    </div>
                                     @endif
                                     @if(isset($documentWithIssue->others))
                                     <p class="m-0">More Details: <em><strong>{{ $documentWithIssue->others }}</strong></em></p>
                                     @endif
                                </div>
                            </div>
                        @elseif ($row->status == 6)
                            <div class="d-flex">
                                <div class="col-md-3 p-2 m-2 neomorphic-bg text-center d-flex">
                                    <div class="col-md-4 neomorphic-bg alt-icon-sz">
                                        <i class="fas fa-undo fa-spin spin-reverse fa-2x text-secondary"></i>
                                    </div>
                                    <div class="col-md-7">
                                        <p class="m-auto pt-3">{{ $row->created_at->format('F j, Y') }} {{ $row->created_at->format('g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="dashed-line">
                                </div>
                                <div class="col-md-7 tracking-details neomorphic-bg">
                                    <p class="p-auto m-0">Sent back by <strong>{{ $row->senderOfficeName }}</strong> to the <strong>{{ $row->receiverOfficeName }}</strong></p>
                                </div>
                            </div>
                        @elseif ($row->status == 7)
                        <div class="d-flex">
                            <div class="col-md-3 p-2 m-2 neomorphic-bg text-center d-flex">
                                <div class="col-md-4 neomorphic-bg bg-warning alt-icon-sz">
                                    <i class="fas fa-tasks fa-2x text-white"></i>
                                </div>
                                <div class="col-md-7">
                                    <p class="m-auto pt-3">{{ $row->created_at->format('F j, Y') }} {{ $row->created_at->format('g:i A') }}</p>
                                </div>
                            </div>
                            <div class="dashed-line">
                            </div>
                            <div class="col-md-7 tracking-details neomorphic-bg text-wrap">
                                <p class="p-auto m-0">Reviewed and Rerecompiled by thee <strong>{{ $row->senderOfficeName }}</strong></p>
                            </div>
                        </div>
                        @elseif ($row->status == 8)
                        <div class="d-flex">
                            <div class="col-md-3 p-2 m-2 neomorphic-bg text-center d-flex">
                                <div class="col-md-4 neomorphic-bg bg-primary alt-icon-sz">
                                    <i class="fas fa-check-double fa-2x text-white"></i>
                                </div>
                                <div class="col-md-7">
                                    <p class="m-auto pt-3">{{ $row->created_at->format('F j, Y') }} {{ $row->created_at->format('g:i A') }}</p>
                                </div>
                            </div>
                            <div class="dashed-line">
                            </div>
                            <div class="col-md-7 tracking-details neomorphic-bg text-wrap">
                                <p class="p-auto m-0">Resubmitted by <strong>{{ $row->senderOfficeName }}</strong></p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endauth

  <script>
    const select = document.getElementById("forward-select");
    const button = document.getElementById("forward-btn");

    select.addEventListener("change", function() {
    if (select.value === "none") {
        button.disabled = true;
    } else {
        button.disabled = false;
    }
    });

    $(document).ready(function() {
    $('#select-reason-reject').on('change', function() {
      var select_value = $(this).val();
      var checkboxes = $('input[name="lacking_doc_id[]"]');

      if (select_value === '1')
      {
        checkboxes.prop('disabled', false);
      }
      else {
        checkboxes.prop('checked', false);
        checkboxes.prop('disabled', true);
      }
        });
    });

  </script>
  <script>
    const forms = document.querySelectorAll('form');

    // Loop through each form and add a submit event listener
    forms.forEach(form => {
        form.addEventListener('submit', event => {
        // Prevent the default form submission behavior
        event.preventDefault();

        // Get the action or link from the form element
        const action = form.action;

        // Show the SweetAlert pop-up
        Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to submit this form.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed'
        }).then((result) => {
      // If the user confirms the submission, submit the form
        if (result.isConfirmed)
            {
                window.location.href = action;
                text: "Status Changed Successfully.",
                icon: "success",
            }
            else{
                text: "No Changes made.",
                icon: "error",
            }
            });
        });
    });
  </script>
   <script>
    document.getElementById("resubmit-form").addEventListener("submit", function(event) {

    // Prevent the form from submitting and the page from refreshing
    event.preventDefault();

    // Call the swal() function inside the event listener
    Swal.fire({
    title: "Are you sure?",
    text: "This action cannot be undone.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Proceed",
    cancelButtonText: "Cancel",
    dangerMode: true,
    })
    .then((willProceed) => {
    if (willProceed.isConfirmed) {
        // The user clicked the "Proceed" button
        // Submit the form
        document.getElementById("resubmit-form").submit();
    } else {
        // The user clicked the "Cancel" button or closed the modal
        Swal.fire({
            text: "No changes made.",
            icon: "error",
        });
    }
    });
    });
    </script>
    <script>
        document.getElementById("approved-and-return-form").addEventListener("submit", function(event) {

        // Prevent the form from submitting and the page from refreshing
        event.preventDefault();

        // Call the swal() function inside the event listener
        Swal.fire({
        title: "Are you sure?",
        text: "This will serve as the final status of the document. This document will be tagged as done and returned to the sender.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Proceed",
        cancelButtonText: "Cancel",
        dangerMode: true,
        })
        .then((willProceed) => {
        if (willProceed.isConfirmed) {
            // The user clicked the "Proceed" button
            // Submit the form
            document.getElementById("approve-and-return-form").submit();
            Swal.fire({
                text: "Status Changed Successfully",
                icon: "success",
            });
        } else {
            // The user clicked the "Cancel" button or closed the modal
            Swal.fire({
                text: "No changes made.",
                icon: "error",
            });
        }
            });
        });
    </script>
    <script>
        document.getElementById("reject-return-to-previous-form").addEventListener("submit", function(event) {

        // Prevent the form from submitting and the page from refreshing
        event.preventDefault();

        // Call the swal() function inside the event listener
        Swal.fire({
        title: "Are you sure?",
        text: "Reject and return to the previous office to be resolved.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Proceed",
        cancelButtonText: "Cancel",
        dangerMode: true,
        })
        .then((willProceed) => {
        if (willProceed.isConfirmed) {
            // The user clicked the "Proceed" button
            // Submit the form
            document.getElementById("reject-return-to-previous-form").submit();
            Swal.fire({
                text: "Status Changed Successfully",
                icon: "success",
            });
        } else {
            // The user clicked the "Cancel" button or closed the modal
            Swal.fire({
                text: "No changes made.",
                icon: "error",
            });
        }
            });
        });
    </script>
    <script>
        document.getElementById("reject-return-to-sender-form").addEventListener("submit", function(event) {

        // Prevent the form from submitting and the page from refreshing
        event.preventDefault();

        // Call the swal() function inside the event listener
        Swal.fire({
        title: "Are you sure?",
        text: "This will serve as the final status of the document and irredeemable.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Proceed",
        cancelButtonText: "Cancel",
        dangerMode: true,
        })
        .then((willProceed) => {
        if (willProceed.isConfirmed) {
            // The user clicked the "Proceed" button
            // Submit the form
            document.getElementById("reject-return-to-sender-form").submit();
            Swal.fire({
                text: "Status Changed Successfully",
                icon: "success",
            });
        } else {
            // The user clicked the "Cancel" button or closed the modal
            Swal.fire({
                text: "No changes made.",
                icon: "error",
            });
        }
            });
        });
    </script>
    <script>
        document.getElementById("resolve-form").addEventListener("submit", function(event) {

        // Prevent the form from submitting and the page from refreshing
        event.preventDefault();

        // Call the swal() function inside the event listener
        Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Proceed",
        cancelButtonText: "Cancel",
        dangerMode: true,
        })
        .then((willProceed) => {
        if (willProceed.isConfirmed) {
            // The user clicked the "Proceed" button
            // Submit the form
            document.getElementById("resolve-form").submit();
            Swal.fire({
                text: "Status Changed Successfully",
                icon: "success",
            });
        } else {
            // The user clicked the "Cancel" button or closed the modal
            Swal.fire({
                text: "No changes made.",
                icon: "error",
            });
        }
            });
        });
    </script>
    <script>
        document.getElementById("approved-and-keep-form").addEventListener("submit", function(event) {

        // Prevent the form from submitting and the page from refreshing
        event.preventDefault();

        // Call the swal() function inside the event listener
        Swal.fire({
        title: "Are you sure?",
        text: "This will serve as the final status of the document and will be tagged to be kept in this office.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Proceed",
        cancelButtonText: "Cancel",
        dangerMode: true,
        })
        .then((willProceed) => {
        if (willProceed.isConfirmed) {
            // The user clicked the "Proceed" button
            // Submit the form
            document.getElementById("approved-and-keep-form").submit();
            Swal.fire({
                text: "Status Changed Successfully",
                icon: "success",
            });
        } else {
            // The user clicked the "Cancel" button or closed the modal
            Swal.fire({
                text: "No changes made.",
                icon: "error",
            });
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
