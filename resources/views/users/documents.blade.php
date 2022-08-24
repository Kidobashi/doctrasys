
@extends('templates.user')
@section('content')
<style>
.active, .btn:hover {
  background-color: #666;
  color: white;
}

#filter, #myDiv2, #myDiv3 {
    display: none;
}

.filter {
    float: right;
}

#nav {
    display: flex;
}
</style>
<div class="col-md-12">
    <h2 class="m-3">My Documents</h2>
        <div id="nav" class="nav">
            <button onclick="showOne()" class="btn border d-flex justify-content-center border border-dark">Completed</button>&nbsp;&nbsp;
            <button onclick="showTwo()" class="btn border d-flex justify-content-center border border-dark">Circulating</button>&nbsp;&nbsp;
            <button onclick="showThree()" class="btn border d-flex justify-content-center border border-dark">Sent Back</button>&nbsp;&nbsp;
            <button onclick="showFilter()" class="btn border d-flex justify-content-center border border-dark">More Filter</button>
            <div class="col-md-8">
                <form action="searchByDate" method="get">
                    <input type="date" style="padding: .5vw;" class="rounded" placeholder="Search by Date" name="dateSearch" type="">
                    <button style="padding: .5vw;" class="rounded" type="submit">Search</button>
                </form>
            </div>
        </div>
</div>

<div class="d-flex mt-6 justify-content-center">
    @if (isset($result))
    @foreach ($result as $row)
        <tr>
            {{-- <td class="text-center"> {{ $loop->iteration }} </td> --}}
            <td class="text-center"> {{ $row->referenceNo }}</td>
            <td class="text-center">{{ $row->receiverName }}</td>
            <td class="text-center">{{ $row->officeName }}</td>
            <td class="d-flex text-center" style="justify-content: center;"><p>Completed</p>&nbsp;<button type="button" class="btn btn-success"></button></td>
            <td class="text-center"><a href="http://127.0.0.1:8000/qrinfo/{{ $row->referenceNo }}" title="Click for more Information">Info</a></td>
        </tr>
    @endforeach
    @elseif (Request::is('documents'))
        <p style="display: none;" class="display-4">Track 'Document' with reference number...</p>
    @else
        <p class="display-4">No 'results' found</td></p>
    @endif
    {{-- @if(isset($data->referenceNo)) --}}
    {{-- <a class="bg-white w-60 border m-2 p-2" href="http://127.0.0.1:8000/qrinfo/{{ $data->referenceNo }}"> --}}
    {{-- <div> --}}
        {{-- <h3>Reference Number : {{ $data->referenceNo }}</h3> --}}
        {{-- <div class="d-flex justify-content-end"> --}}
            {{-- <p class="details">{{ date_format($data->created_at,'M d Y h:i a') }}</p> --}}
        {{-- </div> --}}
    {{-- </div></a> --}}
    {{-- @elseif (Request::is('index')) --}}
        {{-- <p class="display-4">Track 'Document' with reference number...</p> --}}
    {{-- @else --}}
    {{-- <p class="display-4">No 'results' found</td></p> --}}
        {{-- @endif --}}
    </div>

    @if (isset($offices))
    <div class="filter float-start" id="filter">
        <form action="">
        <select name="receiverOffice" class="form-control">
            <option value="" selected disabled>Receiving Office
                @foreach ($offices as $row)
                    <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                </option>
                @endforeach
            </select>
            </select>
            <button class="btn border d-flex justify-content-center border border-dark">Filter</button>
        </form>
    </div>
    @endif

    {{-- <div id="myDiv1">
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
                @foreach ($result as $row)
                    <tr>
                        <td class="text-center"> {{ $loop->iteration }} </td>
                        <td class="text-center"> {{ $row->referenceNo }}</td>
                        <td class="text-center">{{ $row->receiverName }}</td>
                        <td class="text-center">{{ $row->officeName }}</td>
                        <td class="d-flex text-center" style="justify-content: center;"><p>Completed</p>&nbsp;<button type="button" class="btn btn-success"></button></td>
                        <td class="text-center"><a href="http://127.0.0.1:8000/qrinfo/{{ $row->referenceNo }}" title="Click for more Information">Info</a></td>
                    </tr>
                @endforeach
            </tbody>
          </table>
      </div> --}}
@if (isset($comps))
  <div id="myDiv1">
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
        @foreach ($comps as $doc)
            <tr>
                <td class="text-center"> {{ $loop->iteration }} </td>
                <td class="text-center"> {{ $doc->referenceNo }}</td>
                <td class="text-center">{{ $doc->receiverName }}</td>
                <td class="text-center">{{ $doc->officeName }}</td>
                <td class="d-flex text-center" style="justify-content: center;"><p>Completed</p>&nbsp;<button type="button" class="btn btn-success"></button></td>
                <td class="text-center"><a href="http://127.0.0.1:8000/qrinfo/{{ $doc->referenceNo }}" title="Click for more Information">Info</a></td>
            </tr>
        @endforeach
        </tbody>
      </table>
  </div>
@endif

@if (isset($circs))
  <div id="myDiv2">
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
        @foreach ($circs as $doc)
            <tr>
                <td class="text-center"> {{ $loop->iteration }} </td>
                <td class="text-center"> {{ $doc->referenceNo }}</td>
                <td class="text-center">{{ $doc->receiverName }}</td>
                <td class="text-center">{{ $doc->officeName }}</td>
                <td class="d-flex text-center" style="justify-content: center;"><p>Circulating</p>&nbsp;<button type="button" class="btn btn-info"></button></td>
                <td class="text-center"><a href="http://127.0.0.1:8000/qrinfo/{{ $doc->referenceNo }}" title="Click for more Information">Info</a></td>
            </tr>
        @endforeach
        </tbody>
      </table>
  </div>
@endif
@if (isset($sentBack))
  <div id="myDiv3">
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
        @foreach ($sentBack as $doc)
            <tr>
                <td class="text-center"> {{ $loop->iteration }} </td>
                <td class="text-center"> {{ $doc->referenceNo }}</td>
                <td class="text-center">{{ $doc->receiverName }}</td>
                <td class="text-center">{{ $doc->officeName }}</td>
                <td class="d-flex text-center" style="justify-content: center;"><p>Sent Back</p>&nbsp;<button type="button" class="btn btn-danger"></button></td>
                <td class="text-center"><a href="http://127.0.0.1:8000/qrinfo/{{ $doc->referenceNo }}" title="Click for more Information">Info</a></td>
            </tr>
        @endforeach
        </tbody>
      </table>
  </div>
  @endif
<script>
function showOne() {
    if (document.getElementById('myDiv1')) {
        if (document.getElementById('myDiv1').style.display == 'none') {
            document.getElementById('myDiv1').style.display = 'block';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('myDiv3').style.display = 'none';
        }
        else {
            document.getElementById('myDiv1').style.display = 'block';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'none';
        }
    }
}

function showTwo() {
    if (document.getElementById('myDiv2')) {
        if (document.getElementById('myDiv2').style.display == 'none') {
            document.getElementById('myDiv1').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'block';
            document.getElementById('myDiv3').style.display = 'none';
        }
        else {
            document.getElementById('myDiv1').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'block';
            document.getElementById('myDiv3').style.display = 'none';
        }
    }
}

function showThree() {
    if (document.getElementById('myDiv3')) {
        if (document.getElementById('myDiv3').style.display == 'none') {
            document.getElementById('myDiv1').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('myDiv3').style.display = 'block';
        }
        else {
            document.getElementById('myDiv1').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('myDiv3').style.display = 'block';
        }
    }
}

function showFilter() {
    if (document.getElementById('filter')) {
        if (document.getElementById('filter').style.display == 'none') {
            document.getElementById('filter').style.display = 'block';
        }
        else {
            document.getElementById('filter').style.display = 'none';
        }
    }
}
</script>

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
