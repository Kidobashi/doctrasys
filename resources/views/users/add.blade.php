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

                                            {{-- <label for="">Receiver Name</label>
                                            <div class="mb-3">
                                            <select class="form-control" id="receiverName" name="receiverName" required>
                                                <option value="" selected disabled>Select Receiver
                                                    @foreach ($users as $row)
                                                    <option value="{{$row->id}}"><p>{{ $row->email }}</p>-<i>{{ $row->name }}</i></option>
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('receiverName')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                            </div> --}}

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
                                                <button onclick="showQr()" class="btn btn-primary shadow" type="submit">Show QR</button>
                                            </div>
                                        </form>
                                </div>
                                <div class="col-md-5">
                                    <div id="qr"">
                                        @include('partials.qrcode')
                                        <button id="dl-png" style="display: none;" >Download QR</button>
                                    </div>
                                </div>
                            </div>

                            @if(session('message'))
                                <div class="alert alert-success"><strong>{{session('message')}}</strong></div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

	<script>
        $(document).ready(function() {
        $('#receiverName').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
                $.ajax({
                    url: '/findCityWithStateID/'+stateID,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                        console.log(data);
                      if(data){
                        $('#receiverOffice').empty();
                        $('#receiverOffice').focus;
                        $('#receiverOffice').append('<option value="">-- Select Office --</option>');
                        $.each(data, function(key, value){
                        $('select[name="receiverOffice"]').append('<option value="'+ value.id +'">' + value.officeName + '</option>');
                    });
                  }else{
                    $('#city').empty();
                  }
                  }
                });
            }else{
              $('#city').empty();
            }
        });
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
// 'http://127.0.0.1:8000/download'
function downloadQr() {
    window.open('http://127.0.0.1:8000/download/'+{{ $refNo }});
    alert('Document is being downloaded...');
}
</script>
@endsection
