@extends('templates.user')
@section('content')
<head>
    <title>Generate QR Code</title>
</head>
<style>
    .container-fluid {
        position: relative;
        top: 40px;
        height: 100%;
    }
</style>

This page took {{ (microtime(true) - LARAVEL_START) }} seconds to render
<div class="container-fluid col-lg-6 col-md-6">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <span class="d-block display-6 text-center"><strong>Generate&nbsp;QR Code</strong></span>
                <div class="card-body">
                    <div class="col-md-12 d-flex">
                        <div class="col-md-7">
                            <form method="POST" action="/add-documents">
                                @csrf
                            <div class="input-group my-3 ml-1 col-md-12">
                                <span class="input-group-text" id="basic-addon1">Sender Name</span>
                                <input type="text" class="form-control" name="senderName" id="name" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->name; }}" readonly>
                                @error('senderName')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3" style="display: none;">
                                <input type="text" class="form-control" name="email" id="name" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->email; }}" readonly>
                                @error('email')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="input-group my-3 ml-1 col-md-12">
                                <span class="input-group-text" id="basic-addon1">Sender Office</span>
                                <input type="text" class="form-control" name="senderOffice" id="name" aria-label="Name" aria-describedby="name" value="{{ $senderOffice }}" readonly>
                                @error('senderName')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="input-group my-3 ml-1 col-md-12">
                                <span class="input-group-text" id="basic-addon1">Receiver Office</span>
                                    <select class="form-control" id="assignedOffice" name="receiverOffice">
                                    <option value="" selected disabled>Select Office
                                        @foreach ($offices as $row)
                                            <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                                            </option>
                                        @endforeach
                                    </select>
                            </div>

                            <div class="input-group my-3 ml-1 col-md-12">
                                <span class="input-group-text" id="basic-addon1">Document Type</span>
                                    <select class="form-control" id="" name="docType" required>
                                    <option value="" selected disabled>Select Document Type
                                        @foreach ($docType as $row)
                                            <option value="{{ $row->id }}">{{ $row->documentName }}</option>
                                            </option>
                                        @endforeach
                                        </select>
                            </div>

                            <div class="btn-toolbar mb-2">
                                <button class="btn btn-primary shadow" type="submit">Submit</button>
                            </div>

                            <div class="btn-toolbar">
                                <button onclick="showQr()" class="btn btn-primary shadow">Show QR</button>
                            </div>
                            </form>
                            <div class="">
                                <a id="showNumber" class="btn btn-primary shadow" type="submit" onclick="liveUpdate()">Show Reference Number</a>
                            </div>
                        </div>
                        <div class="col-md mx-auto" style="width: 100%; height: 100%; max-width:320px; max-height:320px;">
                            <div id="qrdata">
                                @include('partials.qrcode')
                            </div>
                                <button id="dl-png" style="display: none;">Download QR</button>
                        </div>

                            @if(session('message'))
                                <div class="alert alert-success"><strong>{{session('message')}}</strong></div>
                            @endif
                            </>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    function liveUpdate()
    {
        // event.preventDefault();
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url:"/getLiveUpdate",
            type:'get',
            data:{
                CSRF_TOKEN
            },
            success:function (data) {
                $(".refNumber").val(data);
            },
            complete:function(data)
            {
                setTimeout(liveUpdate, 3000);
            }
        })
    }

    $(document).ready(function(){
    setTimeout(liveUpdate,3000);
    });
</script>
{{-- <script src="../../../public/js/html2canva.js"></script> --}}
<script type="text/javascript" src="{{URL::asset('assets/js/html2canva.min.js')}}"></script>
<script src="../public/assets/js/html2canva.min.js"></script>
<script>
    document.getElementById("dl-png").onclick = function() {
        const screenshotTarget = document.getElementById("qr");

        html2canvas(screenshotTarget).then((canvas) => {
            const base64image = canvas.toDataURL("image/png");
            var anchor = document.createElement('a');
            anchor.setAttribute("href", base64image);
            anchor.setAttribute("download", "qrcode.png");
            anchor.click();
            anchor.remove();
        });
    };
</script>
<script>
function showQr() {
  var x = document.getElementById("qr");
  var y = document.getElementById("dl-png");
  if (x.style.display === "block") {
    x.style.display = "none";
    y.style.display = "none";
  } else {
    x.style.display = "block";
    y.style.display = "block";
  }
}

function downloadQr() {
    window.open('http://127.0.0.1:8000/download/'+{{ $refNo }});
    alert('Document is being downloaded...');
}
</script>
@endsection
