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
    <div class="card">
        @isset($status)
        @if ($status == 'received')
            <div class="card-body">
                <p class="card-text text-right">Date: {{ $date }} - {{ $time }}</p>

                <p class="card-text">Dear {{ $user->name }},</p>
                <p class="card-text">Your document "{{ $referenceNo }}" has been
                <strong>{{ $status }}</strong> by
                {{ $senderOffice->receiver->officeName }}.
                </p>

                <p class="card-text">Best regards,<br>
                CMU Doctrasys</p>

            <a href="{{ route('qrinfo', $referenceNo) }}" class="btn btn-primary">Click here to redirect to document</a>
            </div>
        @elseif($status == 'forwarded')
        <div class="card-body">
            <p class="card-text text-right">Date: {{ $date }} - {{ $time }}</p>

            <p class="card-text">Dear {{ $user->name }},</p>
            <p class="card-text">Your document "{{ $referenceNo }}" has been
            <strong>{{ $status }}</strong> by
            {{ $senderOffice }} to {{ $receiverOffice }}.
            </p>

            <p class="card-text">Best regards,<br>
            CMU Doctrasys</p>

        <a href="{{ route('qrinfo', $referenceNo) }}" class="btn btn-primary">Click here to redirect to document</a>
        </div>
        @endif
        @endisset
    </div>

</body>
</html>
