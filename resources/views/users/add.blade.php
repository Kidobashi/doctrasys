@extends('templates.user')
@section('content')
<style>
    #qrdata{
        display: none;
    }

    .details {
        display: flex;
    }

    .button-container{
        display: flex;
        justify-content: space-between;
    }

    .button-container button {
        margin-right: 10px;
    }

    @media screen and (max-width: 700px)
    {
    .details {
        display: block;
        }
    }
</style>

This page took {{ number_format((microtime(true) - LARAVEL_START),3)}} seconds to render
<div class="container-fluid col-lg-6 col-md-6">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <span><h1 class="display-6 text-center"><strong>Generate&nbsp;QR Code</strong></h1></span>
                <div class="card-body">
                    <div class="details col-md-12 justify-content-center">
                        <div class="col-md-7">
                            <form id="post-form" method="POST" action="/add-documents">
                                @csrf
                            <div class="input-group my-3 ml-1 col-md-12">
                                <span class="input-group-text" id="basic-addon1">Sender Name</span>
                                <input type="text" class="form-control" name="senderName" id="name" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->name }}" readonly>
                                <div class="mb-3" style="display: none;">
                                    <input type="text" class="form-control" name="senderName" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->name }}" readonly>
                                </div>
                                @error('senderName')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="invis-input" class="mb-3" style="display: none;">
                                <input type="text" class="form-control" name="email" id="name" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->email }}" readonly>
                                <input type="text" class="form-control" name="referenceNo" id="name" aria-label="Name" aria-describedby="name" value="{{ $refNo }}" readonly>
                                <input type="text" class="form-control" name="senderOffice" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->assignedOffice }}" readonly>
                            </div>

                            <div class="input-group my-3 ml-1 col-md-12">
                                <span class="input-group-text" id="basic-addon1">Sender Office</span>
                                <input type="text" class="form-control" id="name" aria-label="Name" aria-describedby="name" value="{{ $senderOffice }}" readonly>
                                @error('senderName')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="input-group my-3 ml-1 col-md-12">
                                <span class="input-group-text" id="basic-addon1">Receiver Office</span>
                                    <select class="form-control" id="assignedOffice" name="receiverOffice" required>
                                    <option value="" selected disabled>Select Office
                                        @foreach ($offices as $row)
                                            <option value="{{ $row->id }}" {{ old('receiverOffice', $document->receiverOffice) == $row->id ? 'selected' : '' }}>{{ $row->officeName }}</option>
                                            </option>
                                        @endforeach
                                    </select>
                            </div>

                            <div class="input-group my-3 ml-1 col-md-12">
                                <span class="input-group-text" id="basic-addon1">Document Type</span>
                                    <select class="form-control" id="" name="docType" required>
                                    <option value="" selected disabled>Select Document Type
                                        @foreach ($docType as $row)
                                            <option value="{{ $row->id }}" {{ old('docType', $document->docType) == $row->id ? 'selected' : '' }}>{{ $row->documentName }}</option>
                                            </option>
                                        @endforeach
                                        </select>
                            </div>

                            <div class="btn-toolbar mb-2">

                            </div>
                            <div class="btn-toolbar button-container">
                                <button type="button" style="display:none;" id="printable-mdl-btn" class="btn btn-primary" data-toggle="modal" data-target="#printable-modal">
                                    Show Printable
                                </button>
                                <button class="btn btn-primary shadow mr-1" id="submit-doc-btn" type="submit">Submit</button>
                                <button type="button" class="btn btn-success float-end" style="display:none;" id="create-btn" style="display: none;" onclick="location.href='{{ url()->current() }}';">Create New +</button>
                            </div>
                            </form>
                        </div>

                        <div id="qrdata" class="col-md-4 m-auto" style="width: 100%; height: 100%; max-width:280px; max-height:280px;">
                            <div>
                                @include('partials.qrcode')
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @if (session('qrpng'))
    <h1>{{ session('qrpng') }}</h1>
    @endif --}}
    <img src='data:image/png;base64,../public/assets/qrcodes/qr20230226030613.png' />
    <img src='data:image/png;base64,{{ asset('qrcodes/qr20230226030610.png') }}'>
    <img src='data:image/png;base64,{{ $qr }}'>
    <div class="modal fade m-0 p-0" id="printable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">

            <div class="modal-body">
                @if(session('sndr') )
                <div class="card p-3">
                    <div class="card-body">
                        <h5 class="card-title "><strong>Document Complete Details</strong></h5>
                            <p>Document Reference Number:<span><h4>{{ session('flashRefNo') }}</h4></span></p>
                            <p>Sending Office:<span><h4>{{ session('sndr') }}</h4></span></p>
                            <p>Receiving Office:<span><h4>{{ session('recv') }}</h4></span></p>
                            <p>Document Type:<span><h4>{{ session('dctyp') }}</h4></span></p>
                            <img src="{{ session('qrcode') }}" alt="QR code">
                        <a href="#" class="btn btn-primary">Download</a>
                    </div>
                </div>
            </div>
            @endif
            <div class="modal-footer m-0 p-0">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>


    <script>
        $(document).ready(function() {
            if ('{{ session('message') }}') {
                $('#submit-doc-btn').hide();
                $('#printable-mdl-btn').show();
                $('#create-btn').show();
                }
            });
        var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
        keyboard: false,
        backdrop: 'static',
        show: false,
        } )
        // $('#post-form').submit(function(event) {
        //     event.preventDefault();
        //     $('#printable-modal').modal('show');

        // });
    </script>
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
{{-- <script type="text/javascript" src="{{URL::asset('assets/js/html2canva.min.js')}}"></script>
<script src="../public/assets/js/html2canva.min.js"></script> --}}
{{-- <script>
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
</script> --}}
<script>
function showQr() {
  var x = document.getElementById("qrdata");
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
