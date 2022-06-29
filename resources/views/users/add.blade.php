@extends('templates.user')
@section('content')
        <div class="row" style="position: relative; right: 30px; bottom:60px;">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card mb-4 mx-4">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="card-body">
                            <form method="POST" action="/add-document">
                                @csrf
                                    <label for="">Sender Name</label>
                                    <div class="mb-3">
                                    <input type="text" class="form-control" name="senderName" id="name" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->name }}" >
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
                                    <div>
                                        <button type="submit">Submit</button>
                                    </div>

                                </form>
                                <label for="">QR Code</label>
                                <button onclick="showQr()">Generate QR</button>
                                <div id="qr" style="display: none;">
                                    @include('partials.qrcode')
                                </div>

                            @if(session('message'))
                                <div class="alert alert-success">{{session('message')}}</div>
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
</script>
@endsection
