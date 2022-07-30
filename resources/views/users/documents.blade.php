
@extends('templates.user')
@section('content')
<h2 class="m-4">My Documents</h2>
<table class="table">
    <thead class="thead-dark">
      <tr>
        <th class="text-center" scope="col">Reference No.</th>
        <th class="text-center" scope="col">Receiver</th>
        <th class="text-center" scope="col">Receiving Office</th>
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
                <td class="d-flex text-center" style="justify-content: center;"><p>Circulating</p>&nbsp;<button type="button" class="btn btn-info"></button></td>
            @endif
            @if ($doc->status == 2)
                <td class="d-flex text-center" style="justify-content: center;"><p>Completed</p>&nbsp;<button type="button" class="btn btn-success"></button></td>
            @endif
            @if ($doc->status == 3)
                <td class="d-flex text-center" style="justify-content: center;"><p>Sent Back</p>&nbsp;<button type="button" class="btn btn-danger"></button></td>
            @endif
        </tr>
    @endforeach
    </tbody>
  </table>
  {!! $docs->links() !!}
@endsection
