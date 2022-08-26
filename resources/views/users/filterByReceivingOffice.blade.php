
@extends('templates.user')
@section('content')
<style>
.active, .btn:hover {
  background-color: #666;
  color: white;
}

#nav {
    display: flex;
}
</style>
<div class="col-md-12">
    <h2 class="m-4">My Documents</h2>
    <a href="{{ url('documents') }}"><button onclick="showThree()" class="btn border d-flex justify-content-center border border-dark">Return</button></a>&nbsp;&nbsp;
</div>

@if (isset($data) && count($data) != 0)
<div id="searchDate" class="search justify-content-center">
    <table class="table">
        <thead class="thead-dark">
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
            @foreach ($data as $row)
                <tr>
                    <td class="text-center"> {{ $loop->iteration }} </td>
                    <td class="text-center"> {{ $row->referenceNo }}</td>
                    <td class="text-center">{{ $row->receiverName }}</td>
                    <td class="text-center">{{ $row->officeName }}</td>
                        @if ($row->status == 3)
                            <td class="d-flex text-center" style="justify-content: center;"><p>Sent Back</p>&nbsp;<button type="button" class="btn btn-danger"></button></td>
                        @endif
                        @if ($row->status == 2)
                            <td class="d-flex text-center" style="justify-content: center;"><p>Circulating</p>&nbsp;<button type="button" class="btn btn-info"></button></td>
                        @endif
                        @if ($row->status == 1)
                        <td class="d-flex text-center" style="justify-content: center;"><p>Completed</p>&nbsp;<button type="button" class="btn btn-success"></button></td>
                        @endif
                    <td class="text-center"><a href="http://127.0.0.1:8000/qrinfo/{{ $row->referenceNo }}" title="Click for more Information">Info</a></td>
                </tr>
            @endforeach
        </tbody>
      </table>
    @elseif (count($data) == 0)
        <p class="display-4 text-center">No 'results' found</td></p>
    @else
        <p class="display-4">No 'results' found</td></p>
    @endif
</div>

<script>

  <script>
    // Add active class to the current button (highlight it)
    var header = document.getElementById("nav");
    var btns = header.getElementsByClassName("btn");
    for (var i = 0; i < btns.length; i++) {
      btns[i].addEventListener("click", function() {
      var current = document.getElementsByClassName("active");
      current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
      });
    }
    </script>
@endsection

