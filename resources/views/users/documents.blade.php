
@extends('templates.user')
@section('content')
<h1>Everthing Documents</h1>
<table class="table table-dark">
    <thead>
      <tr>
        <th class="text-center" scope="col">Reference No.</th>
        <th class="text-center" scope="col">Receiver</th>
        <th class="text-center" scope="col">to Office</th>
        <th class="text-center" scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($docs as $doc)
        <tr>
            <td class="text-center"> {{ $doc->referenceNo }}</td>
            <td class="text-center">{{ $doc->receiverName }}</td>
            <td class="text-center">{{ $doc->officeName }}</td>
            @if ($doc->status == 1)
                <td class="d-flex text-center" style="justify-content: center;"><p>On Going</p>&nbsp;<button type="button" class="btn btn-warning"></button></td>
            @endif
            @if ($doc->status == 2)
                <td class="d-flex text-center" style="justify-content: center;"><p>Completed</p>&nbsp;<button type="button" class="btn btn-success"></button></td>
            @endif
        </tr>
    @endforeach
    </tbody>
  </table>
@endsection
