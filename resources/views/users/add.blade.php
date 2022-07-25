@extends('templates.user')
@section('content')
<head>
    <title>Create Traceable Document</title>
</head>
@include('layouts.navbars.auth.nav')
<div class="container-fluid col-lg-6 col-md-6">
        <div class="row">
                <div class="card">
                    <div class="card-body">
                        <span class="d-block display-6 text-center"><strong>Create&nbsp;Traceable Document</strong></span>
                        <div class="card-body">
                            <form method="POST" action="/add-documents">
                                @csrf
                                    <label for="">Sender Name</label>
                                    <div class="mb-3">
                                    <input type="text" class="form-control" name="senderName" id="name" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->name; }}" >
                                    @error('senderName')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="">Sender Office</label>
                                        <input type="text" class="form-control" name="senderOffice" id="name" aria-label="Name" aria-describedby="name" value="{{ $senderOffice }}" >
                                    </div>

                                    <label for="">Receiver Name</label>
                                    <div class="mb-3">
                                    <input type="text" class="form-control" name="receiverName" id="name" aria-label="Name" aria-describedby="name">
                                    @error('receiverName')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="">Receiver Office</label>
                                        <select class="form-control" id="assignedOffice" name="receiverOffice">
                                            <option value="" selected disabled>Select Office
                                                @foreach ($offices as $row)
                                                <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="btn-toolbar">
                                        <button onclick="showQr()" class="btn btn-primary shadow" type="submit">Show QR</button>
                                    </div>

                                    <div class="btn-toolbar">
                                        <button class="btn btn-primary shadow" type="submit">Submit</button>
                                    </div>
                                </form>

                                <button id="dl-png" style="display: none;" >Download QR</button>
                                {{-- <label for="">QR Code</label>
                                <button onclick="showQr()">Generate QR</button> --}}
                                <div id="qr" style="display: none; position: absolute;">
                                    @include('partials.qrcode')
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
