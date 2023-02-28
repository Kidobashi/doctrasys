@extends('templates.user')
@section('content')
<style>
    @media print {
  /* Hide everything except the specified div */

    body * {
        visibility: hidden;
    }
    #printable-modal #mdl-con, #printable-modal #mdl-con * {
    visibility: visible;
    }
    #printable-modal #mdl-con {
        page-break-after: always;
        width: 100vw;
        height: 100vh;
        margin: 0 auto;
    }
    @page {
        size: A4;
        position: fixed;
        width: 100vw;
        height: 100vh;
        top: 100px;
        margin: 0 auto;
    }

    @page {
        size: Letter;
        position: fixed;
        width: 100vw;
        height: 100vh;
        top: 100px;
        margin: 0 auto;
    }

    @page {
        size: Legal;
        position: fixed;
        width: 100vw;
        height: 100vh;
        top: 100px;
        margin: 0 auto;
    }

    @page {
        size: Folio;
        position: fixed;
        width: 100vw;
        height: 100vh;
        top: 100px;
        margin: 0 auto;
    }
}

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

    .modal-btn-container {
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

                            <div id="invis-input" class="mb-3" style="display: none;">
                                <input type="text" class="form-control" name="senderName" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->name }}" readonly>
                                <input type="text" class="form-control" name="email" id="name" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->email }}" readonly>
                                <input type="text" class="form-control" name="referenceNo" id="name" aria-label="Name" aria-describedby="name" value="{{ $refNo }}" readonly>
                                <input type="text" class="form-control" name="senderOffice" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->assignedOffice }}" readonly>
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

    <div class="modal fade m-0 p-0" id="printable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    @if(session('sndr') )
                    <div class="container mdl-container m-0" id="mdl-con">
                        <div class="row p-3" style="border-bottom: 1px solid black; display: flex; justify-content: center; align-items: center;">
                            <div class="col-6 p-3 text-center"> <!-- 1/2 column width, centered -->
                                <p>Document Reference Number:</p>
                                <h2><strong>{{ session('flashRefNo') }}</strong></h2>
                            </div>
                            <div class="col-6 p-3 text-center" style="border-left: 1px solid black;"> <!-- 1/2 column width, centered -->
                                <img src="{{ session('qrcode') }}" alt="QR code">
                            </div>
                        </div>
                        <div class="row p-3" style="display: flex; justify-content: center; align-items: center;">
                            <div class="col-4 text-center"> <!-- 1/3 column width, centered -->
                                <p>Sending Office:</p>
                                <h5>{{ session('sndr') }}</h5>
                            </div>
                            <div class="col-4 text-center" style="border-right: 1px solid black; border-left: 1px solid black;"> <!-- 1/3 column width, centered -->
                                <p>Receiving Office:</p>
                                <h5>{{ session('recv') }}</h5>
                            </div>
                            <div class="col-4 text-center"> <!-- 1/3 column width, centered -->
                                <p>Document Type:</p>
                                <h5>{{ session('dctyp') }}</h5>
                            </div>
                        </div>
                    </div>
                  @endif

                    <div class="modal-footer modal-btn-container m-0 p-0">
                        <div style=" display: flex; justify-content: space-between;">
                            <button class="btn btn-primary" id="download-btn" style="margin-right: 10px;">Download</button>
                            <button class="btn btn-success" id="print-btn" onclick="printDiv()">Print</button>
                        </div>
                        <div class="">
                            <button type="button" class="btn btn-secondary" id="close-btn" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>


<script>

    $(document).ready(function()
    {
        if ('{{ session('message') }}')
        {
            $('#submit-doc-btn').hide();
            $('#printable-mdl-btn').show();
            $('#create-btn').show();
        }
    });

    function printDiv() {
    // Get the print CSS file and append it to the head
    var printCss = document.createElement('link');
    printCss.rel = 'stylesheet';
    printCss.type = 'text/css';
    printCss.href = '{{ asset('css/app.css') }}';
    document.head.appendChild(printCss);

    // Trigger the print dialog
    window.print();

    // Remove the print CSS file from the head
    document.head.removeChild(printCss);
    }

    const downloadBtn = document.getElementById('download-btn');
    const contentDiv = document.getElementById('mdl-con'); // replace with the ID of your content div
    const fileRefNo = {{ session('flashRefNo') }};

    downloadBtn.addEventListener('click', () => {

        // display the flash message on the page
        const flashEl = document.createElement('div');
        flashEl.innerText = fileRefNo;
        document.body.appendChild(flashEl);

        const filename = fileRefNo.toString().replace(/\W+/g, '-').toLowerCase() + '.pdf';
        const options = {
            filename: filename,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { format: 'letter', orientation: 'portrait' },
        };

        html2pdf()
        .from(contentDiv)
        .set(options)
        .save();

        // remove the flash message from the page
        document.body.removeChild(flashEl);
    });

    var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
    keyboard: false,
    backdrop: 'static',
    show: false,
    })
    </script>
<script>
function downloadQr() {
    window.open('http://127.0.0.1:8000/download/'+{{ $refNo }});
    alert('Document is being downloaded...');
}
</script>
@endsection
