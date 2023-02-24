@extends('templates.user')
@section('content')
<style>
    #qrdata{
        display: none;
    }

    .details {
        display: flex;
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
                            {{-- $identity = $last->id + 1;
                            $number = sprintf('%04d', $identity);
                            $prefix = date('Ymd');
                            $stringVal = strval($number); --}}
                            {{-- {{ $prefix = date('Ymd')}}
                            {{  dd("$prefix")}} --}}
                            <div class="btn-toolbar mb-2">

                            </div>
                            <div class="btn-toolbar">
                                <button class="btn btn-primary shadow mr-1" type="submit">Submit</button>
                                <button onclick="showQr()" class="btn btn-primary shadow">Show QR</button>
                            </div>
                            </form>

                            {{-- <div class="">
                                <a id="showNumber" class="btn btn-primary shadow" type="submit" onclick="liveUpdate()">Show Reference Number</a>
                            </div> --}}
                        </div>
                        <div id="qrdata" class="col-md-4 m-auto" style="width: 100%; height: 100%; max-width:280px; max-height:280px;">
                            <div>
                                @include('partials.qrcode')
                                {{-- <button id="dl-png" style="display: none;">Download QR</button> --}}
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Post</h5>
                    {{-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <p>From: <span id="senderOffice"></span></p>
                    <p>To: <span id="receiverOffice"></span></p>
                    <p>Document Type: <span id="docType"></></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
        keyboard: false,
        backdrop: 'static',
        show: false,
        } )
        // $('#post-form').submit(function(event) {
        //     event.preventDefault();

        //     // send the form data as a post request
        //     $.post($(this).attr('action'), $(this).serialize())
        //         .done(function(data) {
        //             //fetch data from database
        //             // console.log(data.senderOffice)
        //             // console.log(data.receiverOffice)
        //             // console.log(data.docType)
        //             const senderOfficeId = data.senderOffice;
        //             const receiverOfficeId = data.receiverOffice;
        //             const docTypeId = data.docType;

        //             // $.get('/fetch-names', {id:senderOfficeId, id:receiverOfficeId, id:docTypeId}, function(data){
        //             //     console.log(data)
        //             //     $('#senderOffice').text(data.senderOfficeName);
        //             //     $('#receiverOffice').text(data.receiverOfficeName);
        //             //     $('#docType').text(data.docTypeName);
        //             // });
        //             // update the modal with the new post data
        //             // $('#senderOffice').text(data.senderOffice);
        //             // $('#receiverOffice').text(data.receiverOffice);
        //             // $('#docType').text(data.docType);

        //             $('#myModal').modal('show');
        //         })
        //         .fail(function(error) {
        //             console.log(error);
        //         });
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
