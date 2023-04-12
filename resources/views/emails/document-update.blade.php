<!DOCTYPE html>
<html>
<head>
    <title>{{ env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
       <!-- Bootstrap & jQuery file -->
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
       <!-- Link to your Javascript file -->

       <script src="https://kit.fontawesome.com/7e4de09da3.js" crossorigin="anonymous"></script>
       <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
       <link rel="preconnect" href="https://fonts.googleapis.com">
       <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
       <link href="https://fonts.googleapis.com/css2?family=Biryani&family=Raleway:wght@600&display=swap" rel="stylesheet">
       <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
       <link rel="stylesheet" href="/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
       <link href="{{ asset('css/app.css') }}" rel="stylesheet">
       <link rel="stylesheet" type="text/css">

       <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

       <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.js"></script>
</head>
<body>
    <style>
        body {
            background-color: rgb(238, 234, 234);
        }
    </style>
    <div style="width: 800px; height: 500px; border: 1px solid rgb(204, 201, 201); margin: 0 auto; margin-top: 20px; text-align: center; background-color:white; border-radius: 5px;">
        @isset($status)
        @if ($status == 2)
        <div style="text-align: center;">
            <h1 style="text-decoration: underline; padding: 30px;"><strong>{{ env('APP_NAME') }}</strong></h1>
        </div>
        <hr>
        <div class="card-body" style="margin: 30px; padding: 10px;">

            <h2 style="margin-bottom: 5px;">Dear <strong>{{ $user->name }}</strong>,</h2>
            <p class="card-text">Your document "<em>{{ $referenceNo }}</em>" has been
            <strong><em>received</em></strong> by the
            {{ $senderOffice }} .
            </p>

            <a href="{{ route('qrinfo', $referenceNo) }}">
            <button style="margin: 20px; padding:5px; text-align: center; background-color:rgb(23, 172, 97); color: white;
            font-size: 30px; font-weight: 700;  border-radius: 5px;"
            >Check Now</button></a>
        </div>
        <div style="width: 92%; height: 118px; background-color:rgb(40, 156, 98); padding: 25px;">
            <p>Or click this link <a href="{{ route('qrinfo', $referenceNo) }}" style="color:white;">https://cmudoctraus.com/1283781273</a></p>
        </div>
        @elseif($status == 3)
        <div style="text-align: center;">
            <h1 style="text-decoration: underline; padding: 30px;"><strong>{{ env('APP_NAME') }}</strong></h1>
        </div>
        <hr>
        <div class="card-body" style="margin: 30px; padding: 10px;">

            <h2 style="margin-bottom: 5px;">Dear <strong>{{ $user->name }}</strong>,</h2>
            <p class="card-text">Your document "<em>{{ $referenceNo }}</em>" is being
            <strong><em>processed</em></strong> by the
            {{ $senderOffice }} .
            </p>

            <a href="{{ route('qrinfo', $referenceNo) }}">
            <button style="margin: 20px; padding:5px; text-align: center; background-color:rgb(23, 172, 97); color: white;
            font-size: 30px; font-weight: 700;  border-radius: 5px;"
            >Check Now</button></a>
        </div>
        <div style="width: 92%; height: 118px; background-color:rgb(40, 156, 98); padding: 25px;">
            <p>Or click this link <a href="{{ route('qrinfo', $referenceNo) }}" style="color:white;">https://cmudoctraus.com/1283781273</a></p>
        </div>
        </div>
        @elseif($status == 4)
        <div style="text-align: center;">
            <h1 style="text-decoration: underline; padding: 30px;"><strong>{{ env('APP_NAME') }}</strong></h1>
        </div>
        <hr>
        <div class="card-body" style="margin: 30px; padding: 10px;">

            <h2 style="margin-bottom: 5px;">Dear <strong>{{ $user->name }}</strong>,</h2>
            <p class="card-text">Your document with reference number [{{ $referenceNo }}] was
            <strong><em>forwarded</em></strong> by the
            {{ $senderOffice }} to {{ $receiverOffice }} .
            </p>

            <a href="{{ route('qrinfo', $referenceNo) }}">
            <button style="margin: 20px; padding:5px; text-align: center; background-color:rgb(23, 172, 97); color: white;
            font-size: 30px; font-weight: 700;  border-radius: 5px;"
            >Check Now</button></a>
        </div>
        <div style="width: 89%; height: 118px; background-color:rgb(40, 156, 98); padding: 25px;">
            <p>Or click this link <a href="{{ route('qrinfo', $referenceNo) }}" style="color:white;">https://cmudoctraus.com/1283781273</a></p>
        </div>
        </div>
        @elseif($status == 5)
        <div style="text-align: center;">
            <h1 style="text-decoration: underline; padding: 30px;"><strong>{{ env('APP_NAME') }}</strong></h1>
        </div>
        <hr>
        <div class="card-body" style="margin: 30px; padding: 10px;">

            <h2 style="margin-bottom: 5px;">Dear <strong>{{ $user->name }}</strong>,</h2>
            <p class="card-text">Your document with reference number [{{ $referenceNo }}] has been evaluated and
            <strong><em style="color:red;">found issues</em></strong> by the
            {{ $senderOffice }}. Wait for current holder of the document to send it back to you.
            </p>

            <a href="{{ route('qrinfo', $referenceNo) }}">
            <button style="margin: 20px; padding:5px; text-align: center; background-color:rgb(23, 172, 97); color: white;
            font-size: 30px; font-weight: 700;  border-radius: 5px;"
            >Check Now</button></a>
        </div>
        <div style="width: 89%; height: 118px; background-color:rgb(40, 156, 98); padding: 25px;">
            <p>Or click this link <a href="{{ route('qrinfo', $referenceNo) }}" style="color:white;">https://cmudoctraus.com/1283781273</a></p>
        </div>
        </div>
        @elseif($status == 6)
        <div style="text-align: center;">
            <h1 style="text-decoration: underline; padding: 30px;"><strong>{{ env('APP_NAME') }}</strong></h1>
        </div>
        <hr>
        <div class="card-body" style="margin: 30px; padding: 10px;">

            <h2 style="margin-bottom: 5px;">Dear <strong>{{ $user->name }}</strong>,</h2>
            <p class="card-text">Your document with reference number [{{ $referenceNo }}] is being returned to you. Please wait for its arrival and process the document to address the issues. Once resolved, you can resubmit the document.</p>

            <a href="{{ route('qrinfo', $referenceNo) }}">
            <button style="margin: 20px; padding:5px; text-align: center; background-color:rgb(23, 172, 97); color: white;
            font-size: 30px; font-weight: 700;  border-radius: 5px;"
            >Check Now</button></a>
        </div>
        <div style="width: 89%; height: 118px; background-color:rgb(40, 156, 98); padding: 25px;">
            <p>Or click this link <a href="{{ route('qrinfo', $referenceNo) }}" style="color:white;">https://cmudoctraus.com/1283781273</a></p>
        </div>
        </div>
        @elseif($status == 7)
        <div style="text-align: center;">
            <h1 style="text-decoration: underline; padding: 30px;"><strong>{{ env('APP_NAME') }}</strong></h1>
        </div>
        <hr>
        <div class="card-body" style="margin: 30px; padding: 10px;">

            <h2 style="margin-bottom: 5px;">Dear <strong>{{ $user->name }}</strong>,</h2>
            <p class="card-text">Your document with reference number [{{ $referenceNo }}] has now arrived. Please resolve the issues with the document and resubmit it.</p>

            <a href="{{ route('qrinfo', $referenceNo) }}">
            <button style="margin: 20px; padding:5px; text-align: center; background-color:rgb(23, 172, 97); color: white;
            font-size: 30px; font-weight: 700;  border-radius: 5px;"
            >Check Now</button></a>
        </div>
        <div style="width: 89%; height: 118px; background-color:rgb(40, 156, 98); padding: 25px;">
            <p>Or click this link <a href="{{ route('qrinfo', $referenceNo) }}" style="color:white;">https://cmudoctraus.com/1283781273</a></p>
        </div>
        </div>
        @elseif($status == 8)
        <div style="text-align: center;">
            <h1 style="text-decoration: underline; padding: 30px;"><strong>{{ env('APP_NAME') }}</strong></h1>
        </div>
        <hr>
        <div class="card-body" style="margin: 30px; padding: 10px;">

            <h2 style="margin-bottom: 5px;">Dear <strong>{{ $user->name }}</strong>,</h2>
            <p class="card-text">Your document with reference number [{{ $referenceNo }}] is now resubmitted. Wait for the next office to receive it.</p>

            <a href="{{ route('qrinfo', $referenceNo) }}">
            <button style="margin: 20px; padding:5px; text-align: center; background-color:rgb(23, 172, 97); color: white;
            font-size: 30px; font-weight: 700;  border-radius: 5px;"
            >Check Now</button></a>
        </div>
        <div style="width: 89%; height: 118px; background-color:rgb(40, 156, 98); padding: 25px;">
            <p>Or click this link <a href="{{ route('qrinfo', $referenceNo) }}" style="color:white;">https://cmudoctraus.com/1283781273</a></p>
        </div>
        </div>
        @elseif($status == 9)
        <div style="text-align: center;">
            <h1 style="text-decoration: underline; padding: 30px;"><strong>{{ env('APP_NAME') }}</strong></h1>
        </div>
        <hr>
        <div class="card-body" style="margin: 30px; padding: 10px;">

            <h2 style="margin-bottom: 5px;">Dear <strong>{{ $user->name }}</strong>,</h2>
            <p class="card-text">Your document with reference number [{{ $referenceNo }}] is now <strong style="color: green;">approved</strong> and decided to keep it by the {{ $receiverOffice }}.</p>

            <a href="{{ route('qrinfo', $referenceNo) }}">
            <button style="margin: 20px; padding:5px; text-align: center; background-color:rgb(23, 172, 97); color: white;
            font-size: 30px; font-weight: 700;  border-radius: 5px;"
            >Check Now</button></a>
        </div>
        <div style="width: 89%; height: 118px; background-color:rgb(40, 156, 98); padding: 25px;">
            <p>Or click this link <a href="{{ route('qrinfo', $referenceNo) }}" style="color:white;">https://cmudoctraus.com/1283781273</a></p>
        </div>
        </div>
        @elseif($status == 10)
        <div style="text-align: center;">
            <h1 style="text-decoration: underline; padding: 30px;"><strong>{{ env('APP_NAME') }}</strong></h1>
        </div>
        <hr>
        <div class="card-body" style="margin: 30px; padding: 10px;">

            <h2 style="margin-bottom: 5px;">Dear <strong>{{ $user->name }}</strong>,</h2>
            <p class="card-text">Your document with reference number [{{ $referenceNo }}] is now <strong style="color: green;">approved</strong> by the {{ $receiverOffice }}.</p>

            <a href="{{ route('qrinfo', $referenceNo) }}">
            <button style="margin: 20px; padding:5px; text-align: center; background-color:rgb(23, 172, 97); color: white;
            font-size: 30px; font-weight: 700;  border-radius: 5px;"
            >Check Now</button></a>
        </div>
        <div style="width: 89%; height: 118px; background-color:rgb(40, 156, 98); padding: 25px;">
            <p>Or click this link <a href="{{ route('qrinfo', $referenceNo) }}" style="color:white;">https://cmudoctraus.com/1283781273</a></p>
        </div>
        </div>
        @elseif($status == 12)
        <div style="text-align: center;">
            <h1 style="text-decoration: underline; padding: 30px;"><strong>{{ env('APP_NAME') }}</strong></h1>
        </div>
        <hr>
        <div class="card-body" style="margin: 30px; padding: 10px;">

            <h2 style="margin-bottom: 5px;">Dear <strong>{{ $user->name }}</strong>,</h2>
            <p class="card-text">Your document with reference number [{{ $referenceNo }}] is now <strong style="color: red;">rejected</strong> by the intended recipient, {{ $receiverOffice }}.</p>

            <a href="{{ route('qrinfo', $referenceNo) }}">
            <button style="margin: 20px; padding:5px; text-align: center; background-color:rgb(23, 172, 97); color: white;
            font-size: 30px; font-weight: 700;  border-radius: 5px;"
            >Check Now</button></a>
        </div>
        <div style="width: 89%; height: 118px; background-color:rgb(40, 156, 98); padding: 25px;">
            <p>Or click this link <a href="{{ route('qrinfo', $referenceNo) }}" style="color:white;">https://cmudoctraus.com/1283781273</a></p>
        </div>
        </div>
        @endif
        @endisset
    </div>

</body>
</html>
