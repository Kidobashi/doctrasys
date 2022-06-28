<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
    <title>Document</title>
</head>
<body>
        <div class="row">
            <div class="col-md">
                    <div class="card-body">
                        <h4 class="card-title">QR Document Details</h4>
                        <h5>Reference No.: {{$data->referenceNo}}</h5>
                        <h5>Sender: {{$data->senderName}}</h5>
                        <h5>Receiver: {{$data->receiverName}}</>
                        <h5>From Office: {{$data->officeName}}</h5>
                        @if( $data->status == '1')
                        <h5>Status: Ongoing </h5>
                        @endif
                        @if($data->status == '2')
                        <h5>Status: Forwarded </h5>
                        @endif
                        @if( $data->status == '3')
                        <h5>Status: Received </h5>
                        @endif

                        <Label>Options</Label>
                        <a href="{{ url('forward/'.$data->referenceNo) }}"><button type="button" class="btn btn-primary">Forward</button></a>
                        <a href="{{ url('receive/'.$data->referenceNo) }}"><button type="button" class="btn btn-success">Receive</button></a>
                    </div>

                    <div class="">
                        <img src="{{ asset('qrcodes/qr'.$data->referenceNo.'.png') }}" alt="tag" style="margin-left:160px;">
                    </div>

                    <h3>TRACKING</h3>
                    <div class="d-flex justify-content-center" style="width: 80%;">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Reference No.: </th>
                                <th scope="col">Sender: </th>
                                <th scope="col">Forwarded to: </th>
                                <th scope="col">From Office: </th>
                                <th scope="col">Forwarded to Office: </th>
                                <th scope="col">Destination Office: </th>
                                <th scope="col">Status: </th>
                                <th>Updated at: </th>
                              </tr>
                            </thead>
                            @foreach($trackings as $tracking)
                            <tbody>
                              <tr>
                                <td>{{ $tracking->referenceNo }}</td>
                                <td>{{ $tracking->senderName }}</td>
                                <td>{{ $tracking->receiverName }}</td>
                                <td>{{ $secAlt->officeName }}</td>
                                <td>{{ $tracking->officeName }}</td>
                                {{-- Add new column for destination --}}
                                <td>{{$alt->officeName}}</td>
                                <td>{{ $tracking->status }}</td>
                                <td>{{ $tracking->updated_at }}</td>
                              </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
            </div>
        </div>
 </body>
</html>
