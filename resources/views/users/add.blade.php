@extends('templates.user')
@section('content')
<head>
    <title>Create Traceable Document</title>
</head>
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
                                    <input type="text" class="form-control" name="senderName" id="name" aria-label="Name" aria-describedby="name" value="" >
                                    @error('senderName')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                    </div>

                                    <label for="">Receiver Name</label>
                                    <div class="mb-3">
                                    <input type="text" class="form-control" name="receiverName" id="name" aria-label="Name" aria-describedby="name">
                                    @error('receiverName')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="">Sender Office</label>
                                        <select class="form-control" id="assignedOffice" name="senderOffice">
                                            <option value="" selected disabled>Select Office
                                                @foreach ($offices as $row)
                                                <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                                            </option>
                                            @endforeach
                                        </select>
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
                                        <button onclick="downloadQr()" class="btn btn-primary shadow" type="submit">Submit</button>
                                        {{-- <div id="qr" style="display:none;">
                                            <a  href="http://127.0.0.1:8000/download">Download</a>
                                        </div> --}}
                                    </div>
                                </form>
                                {{-- <label for="">QR Code</label>
                                <button onclick="showQr()">Generate QR</button>
                                <div id="qr">
                                    @include('partials.qrcode')
                                </div> --}}

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
function showQr() {
  var x = document.getElementById("qr");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}

function downloadQr() {
    window.open('http://127.0.0.1:8000/download');
    alert('Document is being downloaded...');
}
</script>
@endsection
