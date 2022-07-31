
@extends('templates.user')
@section('content')
<style>
.active, .btn:hover {
  background-color: #666;
  color: white;
}

#myDiv2, #myDiv3 {
    display: none;
}
</style>

<h2 class="m-4">My Documents</h2>
<div class="nav list-group list-group-flush">
    <ul id="nav" class="nav d-flex">
        <button onclick="showOne()" class="btn border d-flex justify-content-center border border-dark">Completed</button>
        <button onclick="showTwo()" class="btn border d-flex justify-content-center border border-dark">Circulating</button>
        <button onclick="showThree()" class="btn border d-flex justify-content-center border border-dark">Something Wrong</button>
    </ul>
</div>

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
                <td class="text-center"><a href="" title="Click for more Information">Info</a></td>
            </tr>
        @endforeach
        </tbody>
      </table>
  </div>

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
                <td class="text-center"><a href="" title="Click for more Information">Info</a></td>
            </tr>
        @endforeach
        </tbody>
      </table>
  </div>

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
                <td class="text-center"><a href="" title="Click for more Information">Info</a></td>
            </tr>
        @endforeach
        </tbody>
      </table>
  </div>

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
            document.getElementById('myDiv1').style.display = 'block';
            document.getElementById('myDiv2').style.display = 'none';
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
