@extends('templates.user')
@section('content')
@if (isset($sentBack))
<div id="myDiv1">
    <div class="bg-white">
        <div class="card">
            <div class="d-flex col-md">
                <div class="input-group p-3">
                    <span class="input-group-text" id="basic-addon1">Filter By:</span>
                    <input type="text" class="form-control" placeholder="Office, Date" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group p-3">
                    <button class="btn btn-primary"><a href="{{ url('documents') }}" style="text-decoration: none; color:white;">All Documents</a></button>
                    <button onclick="showOne()" class="btn btn-success">Completed</button>
                    <button onclick="showTwo()" class="btn btn-info">Circulating</button>
                    <button onclick="showThree()" class="btn btn-danger">Sent Back</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="container">
        <div class="card bg-white">
            <div class="m-3">
                <button class="btn btn-success float-right" data-toggle="modal" data-target="#addSubscriberModal">+ Add new Document</button>
                <div class="card-header bg-white">
                    <h4>List of Documents</h4>
                </div>
                <div class="card-body">
                    <table class="table text-center">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center" scope="col">No.</th>
                                <th class="text-center" scope="col">Reference No.</th>
                                <th class="text-center" scope="col">Receiver</th>
                                <th class="text-center" scope="col">Receiving Office</th>
                                <th class="text-center" scope="col">Status</th>
                                <th class="text-center" scope="col">Details</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach ($sentBack as $doc)
                                <tr>
                                    <td class="text-center"> {{ $loop->iteration }} </td>
                                    <td class="text-center"> {{ $doc->referenceNo }}</td>
                                    <td class="text-center">{{ $doc->receiverName }}</td>
                                    <td class="text-center">{{ $doc->officeName }}</td>
                                    @if ($doc->status == 3)
                                        <td><span class="badge bg-danger d-inline">Sent Back</span></td>
                                    @endif
                                    @if ($doc->status == 2)
                                        <td><span class="badge bg-success d-inline">Completed</span></td>
                                    @endif
                                    @if ($doc->status == 1)
                                        <td><span class="badge bg-info d-inline">Circulating</span></td>
                                    @endif
                                    <td class="text-center"><a href="http://127.0.0.1:8000/qrinfo/{{ $doc->referenceNo }}" title="Click for more Information"><i class="fa fa-link" aria-hidden="true"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    <div class="float-right">
                        {{ $sentBack->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endif
<script>
    function showOne() {
    window.location.href = "http://127.0.0.1:8000/documents/completed";
}

function showTwo() {
    window.location.href = "http://127.0.0.1:8000/documents/circulating";
}

function showThree() {
    window.location.href = "http://127.0.0.1:8000/documents/sentBack";
}
</script>
@endsection
