@extends('templates.user')
@section('content')
<style>
.instruction{
    min-width: 350px;;
}

select {
    width: 100%;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: transparent;
    border: 1px solid #ccc;
    padding: 5px;
    font-size: 16px;
    cursor: pointer;
  }
  select option {
    padding: 10px;
    font-size: 16px;
  }
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

    #mdl-con .first-row{
        border-bottom: 1px solid black;
    }

    @page {
        size: A4;
        position: fixed;
        width: 100%;
        height: 100vh;
        top: 100px;
        margin: 0px;
        scale: 2;
    }

    @page {
        size: Letter;
        position: fixed;
        width: 100%;
        height: 100vh;
        top: 100px;
        margin: 0px;
        scale: 2;
    }

    @page {
        size: Legal;
        position: fixed;
        width: 100%;
        height: 100vh;
        top: 100px;
        margin: 0 auto;
    }

    @page {
        size: Folio;
        position: fixed;
        width: 100%;
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

        .alternative {
            display: none;
        }
    }
</style>

<div class="container-fluid mb-3">
    <div class="row">
        <div class="col-md-12">
            <div class="mt-3 mb-1">
                <div class="row justify-content-between">
                    @isset($totalDocByUser)
                    <div class="col-md-1 m-auto p-3 levitating-div bg-white rounded">
                        <h2 class="font-weight-bolder mb-0">
                            {{ $totalDocByUser }}
                        </h2>
                        <p class="text-sm mb-0 text-capitalize text-wrap">Documents Created</p>
                    </div>
                    @endisset
                    @foreach ($eachDocTypeCount as $eachDoc)
                    <div class="col-md-2 m-auto p-3 levitating-div bg-white rounded">
                        <h2 class="font-weight-bolder mb-0">
                            {{ $eachDoc->total }}
                        </h2>
                        <p class="text-sm mb-0 text-capitalize text-wrap">{{ $eachDoc->docType }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid col-lg-6 col-md-6 levitating-div">
    <div class="row bg-light p-3 rounded">
        <span><h1 class="display-6 text-center"><strong>Generate&nbsp;QR Code</strong></h1></span>
            <div class="card-body">
                <div class="details col-md-12 justify-content-center">
                    <div class="col-md-7">
                    <form id="post-form" method="POST" action="/add-documents">
                    @csrf

                    <div id="invis-input" class="mb-3" style="display: none;">
                        <input type="text" class="form-control" name="user_id" id="name" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->id }}" readonly>
                        <input type="text" class="form-control" name="referenceNo" id="name" aria-label="Name" aria-describedby="name" value="{{ $refNo }}" readonly>
                        <input type="text" class="form-control" name="senderOffice_id" aria-label="Name" aria-describedby="name" value="{{ Auth::user()->assignedOffice }}" readonly>
                    </div>
                    {{-- {{ dd($refNo) }} --}}
                    <div class="input-group my-3 ml-1 col-md-12">
                        <span class="input-group-text" id="basic-addon1">Recipient Office</span>
                            <select class="form-control" id="assignedOffice" name="receiverOffice_id" required>
                            <option class="p-1 m-1" value="" selected disabled>Select Office
                                @foreach ($offices as $row)
                                    <option style="margin: 3px;" value="{{ $row->id }}" {{ old('receiverOffice_id', session('recv') ) == $row->id ? 'selected' : '' }}>{{ $row->officeName }}</option>
                                    </option>
                                @endforeach
                            </select>
                    </div>

                    <div class="input-group my-3 ml-1 col-md-12">
                        <span class="input-group-text" id="basic-addon1">Document Type</span>
                            <select class="form-control" id="" name="docType" required>
                            <option value="" selected disabled>Select Document Type
                                @foreach ($docType as $row)
                                    <option class="p-1" value="{{ $row->id }}" {{ old('docType', session('dctyp') ) == $row->id ? 'selected' : '' }}>{{ $row->docType }}</option>
                                    </option>
                                @endforeach
                            </select>
                    </div>

                    <div class="btn-toolbar button-container">
                        <button type="button" style="display:none;" id="printable-mdl-btn" class="btn btn-primary" data-toggle="modal" data-target="#printable-modal">
                            Show QR Code
                        </button>
                        <button class="btn btn-success shadow mr-1" id="submit-doc-btn" type="submit"><strong>Generate</strong></button>
                        <div class="btn-group dropdown" id="help-btn">
                            <button type="button" class="btn btn-primary" id="help-btn" data-toggle="dropdown">
                                <strong>Need help?</strong>
                            </button>
                            <div class="dropdown-menu">
                                  <!-- Dropdown menu links -->
                                <div class="d-flex flex-wrap bg-white p-3 instruction">
                                    <p>To generate the QR Code, follow these steps:</p>
                                    <p>1. Fill-in the <strong><em>Recipient Office field</em></strong> by choosing among the the list of offices.</p>
                                    <p>2. Fill-in the <strong><em>Document Type field</em></strong> by selecting among the the list of document types.</p>
                                    <p>3. <strong><em>Click Generate</strong></em></p>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success float-end" style="display:none;" id="create-btn" style="display: none;" >Create New +</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="alternative" style="height: 59%;">

</div> --}}

    <div class="modal fade m-0 p-0" id="printable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="container">
                    @if(session('sndr') )
                    <div class="container mdl-container m-0" id="mdl-con">
                        <div class="row d-xs-block first-row p-3">
                            <div class="p-3 text-center"> <!-- 1/2 column width, centered -->
                                <p>Reference Number:</p>
                                <h2><strong>{{ session('flashRefNo') }}</strong></h2>
                            </div>
                            <div class="p-3 text-center" id="img-only"> <!-- 1/2 column width, centered -->
                                <img src="{{ session('qrcode') }}" alt="QR code" width="200" height="200" style="width: 200px; height:200px;">
                            </div>
                        </div>
                        <div class="row d-xs-block d-md-flex d-lg-flex d-sm-flex .d-print-flex second-row p-3">
                            <div class="text-center"> <!-- 1/3 column width, centered -->
                                <p>Office of Origin:</p>
                                <h5>{{ session('sndr') }}</h5>
                            </div>
                            <div class="text-center"> <!-- 1/3 column width, centered -->
                                <p>Recipient Office:</p>
                                <h5>{{ session('recv') }}</h5>
                            </div>
                            <div class="text-center"> <!-- 1/3 column width, centered -->
                                <p>Document Type:</p>
                                <h5>{{ session('dctyp') }}</h5>
                            </div>
                        </div>
                    </div>
                  @endif

                    <div class="modal-footer modal-btn-container m-0 p-0">
                        <div class="d-lg-flex d-md-flex d-sm-block d-xs-block justify-content-between justify-content-sm-center justify-content-xs-center text-xs-center">
                            <button class="btn btn-primary" id="download-btn" style="margin-right: 10px;">Download</button>
                            <button class="btn btn-success" id="print-btn" style="margin-right: 10px;" onclick="printDiv()">Print</button>
                            <button type="button" class="btn btn-outline-success" style="margin-right: 10px;" id="dl-img">Download (QR Code Image Only)</button>
                            <button type="button" class="btn btn-warning" onclick="()" data-toggle="modal" data-target="#myModal">Need help?</button>
                        </div>
                        <div class="">
                            <button type="button" class="btn btn-secondary" id="close-btn" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<footer class="footer py-3 bg-light mt-5">
    <div class="container text-center">
    <span class="text-muted">&copy; {{ date('Y') }} {{ config('app.name') }}</span>
    </div>
</footer>
<!-- Button to trigger modal -->

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Guide</h4>
        </div>
        <div class="modal-body">
          <p><strong>Download</strong> button will download a PDF file of the QR Code along with the details. Like how it is shown.</p>
          <p><strong>Print</strong> button will open a print window to print the QR Code along with the details.</p>
          <p><strong>Download(QR Code Image Only)</strong> button will download a PNG file of the QR Code only to be inserted into documents.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<script>
$('#post-form').submit(function() {
  $('#submit-doc-btn').prop('disabled', true);
});
</script>
<script>
$(document).ready(function() {
    const message = '{{ session('message') }}';
    const submitBtn = $('#submit-doc-btn');
    const helpBtn = $('#help-btn');
    const printableBtn = $('#printable-mdl-btn');
    const createBtn = $('#create-btn');

    if (message) {
        submitBtn.hide();
        helpBtn.hide();
        printableBtn.toggle();
        createBtn.toggle();
    }
});

function guideAlert(message) {
    alert(message);
}

function printDiv() {
    // Get the print CSS file and append it to the head
    const printCss = document.createElement('link');
    printCss.rel = 'stylesheet';
    printCss.type = 'text/css';
    printCss.href = '{{ asset('css/app.css') }}';
    document.head.appendChild(printCss);

    // Trigger the print dialog
    window.print();

    // Remove the print CSS file from the head
    document.head.removeChild(printCss);
}

const qrImgDlBtn = document.getElementById('dl-img');

qrImgDlBtn.addEventListener('click', function() {
    // Get the div element and the image element
    const filename = "{{ session('flashRefNo') }}";
    const div = document.getElementById('img-only');
    const img = div.getElementsByTagName('img')[0];
    const canvas = document.createElement('canvas');

    // Create a new anchor element for downloading
    canvas.width = img.width;
    canvas.height = img.height;

    // Draw the image on the canvas
    const context = canvas.getContext('2d');
    context.drawImage(img, 0, 0);

    const base64 = canvas.toDataURL('image/png');

    const downloadLink = document.createElement('a');

    // Set the href attribute of the anchor element to the image source
    downloadLink.href = base64;

    // Set the download attribute of the anchor element to the image name
    downloadLink.download = filename;

    // Append the anchor element to the div
    document.body.appendChild(downloadLink);

    // Simulate a click on the anchor element to start the download
    downloadLink.click();

    // Remove the anchor element from the div
    div.removeChild(downloadLink);
});

const myModal = new bootstrap.Modal(document.getElementById('myModal'), {
    keyboard: false,
    backdrop: 'static',
    show: false,
});

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.js"></script>
<script>
const downloadBtn = document.getElementById('download-btn');
const contentDiv = document.getElementById('mdl-con');
const fileRefNo = "{{ session('flashRefNo') }}";

downloadBtn.addEventListener('click', () => {
  const flashEl = document.createElement('div');
  flashEl.innerText = fileRefNo;

  const filename = `${fileRefNo.toString().replace(/\W+/g, '-').toLowerCase()}.pdf`;
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

  document.body.removeChild(flashEl);
});
</script>
{{-- <script>
    $(document).ready(function()
    {
        if ('{{ session('message') }}')
        {
            $('#submit-doc-btn').hide();
            $('#help-btn').hide();
            $('#printable-mdl-btn').show();
            $('#create-btn').show();
        }
    });

    function guideAlert(message) {
        alert(message);
    }

    function printDiv() {
    // Get the print CSS file and append it to the head
    var printCss = document.createElement('link');
    printCss.rel = 'stylesheet';
    printCss.type = 'text/css';
    printCss.href = '{{ asset('css/app.css') }}';
    document.head.appendChild(printCss);

    console.log();

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

    var qrImgDlBtn = document.getElementById("dl-img");

    qrImgDlBtn.addEventListener("click", function() {
        // Get the div element and the image element
        var filename = "{{ session('flashRefNo') }}";
        var div = document.getElementById("img-only");
        var img = div.getElementsByTagName("img")[0];
        var canvas = document.createElement("canvas");

        // Create a new anchor element for downloading
        canvas.width = img.width;
        canvas.height = img.height;

        // Draw the image on the canvas
        var context = canvas.getContext("2d");
            context.drawImage(img, 0, 0);

        var base64 = canvas.toDataURL("image/png");

        var downloadLink = document.createElement("a");

        // Set the href attribute of the anchor element to the image source
        downloadLink.href = base64;

        // Set the download attribute of the anchor element to the image name
        downloadLink.download = filename;

        // Append the anchor element to the div
        document.body.appendChild(downloadLink);

        // Simulate a click on the anchor element to start the download
        downloadLink.click();

        // Remove the anchor element from the div
        div.removeChild(downloadLink);
    });

    var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
    keyboard: false,
    backdrop: 'static',
    show: false,
    })
</script> --}}
@endsection
