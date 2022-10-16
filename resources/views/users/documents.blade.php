
@extends('templates.user')
@section('content')
<style>
.active, .btn:hover {
  background-color: #666;
  color: white;
}

#filter, #myDiv2, #myDiv3, #myDiv1{
    display: none;
}

.filter {
    float: right;
}

#nav {
    display: flex;
}
</style>
This page took {{ (microtime(true) - LARAVEL_START) }} seconds to render
    @if (isset($offices))
    <div class="filter float-start" id="filter">
        <form action="filterByRcvOffice" method="get">
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

    @if (count($all) == '0')
            <p class="display-4">No documents found</p>
      @elseif (isset($all) != 0)
      <div id="All">
        <div class="container mb-4">
            <div class="card bg-white">
                <div class="input-group my-3 mx-3 col-md-12">
                    <span class="input-group-text" id="basic-addon1">Filter By:</span>
                    <input type="text" class="form-control mr-5" placeholder="Office, Date" aria-label="Username" aria-describedby="basic-addon1">
                    <div class="input-group-prepend mx-3">
                        <button onclick="showAll()" class="btn btn-primary">All Documents</button>
                        <button onclick="showOne()" class="btn btn-success">Completed</button>
                        <button onclick="showTwo()" class="btn btn-info">Circulating</button>
                        <button onclick="showThree()" class="btn btn-danger">Sent Back</button>
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
                                @foreach ($all as $doc)
                                    <tr>
                                        <td class="text-center"> {{ $loop->iteration }} </td>
                                        <td class="text-center"> {{ $doc->referenceNo }}</td>
                                        <td class="text-center">{{ $doc->receiverName }}</td>
                                        <td class="text-center">{{ $doc->officeName }}</td>
                                        @if ($doc->status == 3)
                                                <td><span class="badge badge-danger d-inline">Sent Back</span></td>
                                            @endif
                                            @if ($doc->status == 2)
                                                <td><span class="badge badge-success d-inline">Completed</span></td>
                                            @endif
                                            @if ($doc->status == 1)
                                            <td><span class="badge badge-info d-inline">Circulating</span></td>
                                            @endif
                                        <td class="text-center"><a href="http://127.0.0.1:8000/qrinfo/{{ $doc->referenceNo }}" title="Click for more Information"><i class="fa fa-link" aria-hidden="true"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="float-right">
                            {{ $all->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      @endif

@if (isset($comps))
<div id="myDiv1">
    <div class="container mb-5">
        <div class="card bg-white">
            <div class="input-group my-3 mx-3 col-md-12">
                <span class="input-group-text" id="basic-addon1">Filter By:</span>
                <input type="text" class="form-control mr-5" placeholder="Office, Date" aria-label="Username" aria-describedby="basic-addon1">
                <div class="input-group-prepend mx-3">
                    <button onclick="showAll()" class="btn btn-primary">All Documents</button>
                    <button onclick="showOne()" class="btn btn-success">Completed</button>
                    <button onclick="showTwo()" class="btn btn-info">Circulating</button>
                    <button onclick="showThree()" class="btn btn-danger">Sent Back</button>
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
                            @foreach ($comps as $doc)
                                <tr>
                                    <td class="text-center"> {{ $loop->iteration }} </td>
                                    <td class="text-center"> {{ $doc->referenceNo }}</td>
                                    <td class="text-center">{{ $doc->receiverName }}</td>
                                    <td class="text-center">{{ $doc->officeName }}</td>
                                    @if ($doc->status == 3)
                                            <td class="d-flex text-center" style="justify-content: center;"><p>Sent Back</p>&nbsp;<button type="button" class="btn btn-danger"></button></td>
                                        @endif
                                        @if ($doc->status == 2)
                                        <td class="d-flex text-center" style="justify-content: center;"><p>Completed</p>&nbsp;<button type="button" class="btn btn-success"></button></td>
                                        @endif
                                        @if ($doc->status == 1)
                                        <td class="d-flex text-center" style="justify-content: center;"><p>Circulating</p>&nbsp;<button type="button" class="btn btn-info"></button></td>
                                        @endif
                                    <td class="text-center"><a href="http://127.0.0.1:8000/qrinfo/{{ $doc->referenceNo }}" title="Click for more Information"><i class="fa fa-link" aria-hidden="true"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    <div class="float-right">
                        {{ $comps->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endif

@if (isset($circs))
<div id="myDiv2">
    <div class="container mb-5">
        <div class="card bg-white">
            <div class="input-group my-3 mx-3 col-md-12">
                <span class="input-group-text" id="basic-addon1">Filter By:</span>
                <input type="text" class="form-control mr-5" placeholder="Office, Date" aria-label="Username" aria-describedby="basic-addon1">
                <div class="input-group-prepend mx-3">
                    <button onclick="showAll()" class="btn btn-primary">All Documents</button>
                    <button onclick="showOne()" class="btn btn-success">Completed</button>
                    <button onclick="showTwo()" class="btn btn-info">Circulating</button>
                    <button onclick="showThree()" class="btn btn-danger">Sent Back</button>
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
                            @foreach ($circs as $doc)
                                <tr>
                                    <td class="text-center"> {{ $loop->iteration }} </td>
                                    <td class="text-center"> {{ $doc->referenceNo }}</td>
                                    <td class="text-center">{{ $doc->receiverName }}</td>
                                    <td class="text-center">{{ $doc->officeName }}</td>
                                    @if ($doc->status == 3)
                                            <td class="d-flex text-center" style="justify-content: center;"><p>Sent Back</p>&nbsp;<button type="button" class="btn btn-danger"></button></td>
                                        @endif
                                        @if ($doc->status == 2)
                                        <td class="d-flex text-center" style="justify-content: center;"><p>Completed</p>&nbsp;<button type="button" class="btn btn-success"></button></td>
                                        @endif
                                        @if ($doc->status == 1)
                                        <td class="d-flex text-center" style="justify-content: center;"><p>Circulating</p>&nbsp;<button type="button" class="btn btn-info"></button></td>
                                        @endif
                                    <td class="text-center"><a href="http://127.0.0.1:8000/qrinfo/{{ $doc->referenceNo }}" title="Click for more Information"><i class="fa fa-link" aria-hidden="true"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    <div class="float-right">
                        {{ $comps->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endif
@if (isset($sentBack))
<div id="myDiv3">
    <div class="container mb-5">
        <div class="card bg-white">
            <div class="input-group my-3 mx-3 col-md-12">
                <span class="input-group-text" id="basic-addon1">Filter By:</span>
                <input type="text" class="form-control mr-5" placeholder="Office, Date" aria-label="Username" aria-describedby="basic-addon1">
                <div class="input-group-prepend mx-3">
                    <button onclick="showAll()" class="btn btn-primary">All Documents</button>
                    <button onclick="showOne()" class="btn btn-success">Completed</button>
                    <button onclick="showTwo()" class="btn btn-info">Circulating</button>
                    <button onclick="showThree()" class="btn btn-danger">Sent Back</button>
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
                            @foreach ($comps as $doc)
                                <tr>
                                    <td class="text-center"> {{ $loop->iteration }} </td>
                                    <td class="text-center"> {{ $doc->referenceNo }}</td>
                                    <td class="text-center">{{ $doc->receiverName }}</td>
                                    <td class="text-center">{{ $doc->officeName }}</td>
                                    @if ($doc->status == 3)
                                            <td class="d-flex text-center" style="justify-content: center;"><p>Sent Back</p>&nbsp;<button type="button" class="btn btn-danger"></button></td>
                                        @endif
                                        @if ($doc->status == 2)
                                        <td class="d-flex text-center" style="justify-content: center;"><p>Completed</p>&nbsp;<button type="button" class="btn btn-success"></button></td>
                                        @endif
                                        @if ($doc->status == 1)
                                        <td class="d-flex text-center" style="justify-content: center;"><p>Circulating</p>&nbsp;<button type="button" class="btn btn-info"></button></td>
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

function showAll() {
    if (document.getElementById('All')) {
        if (document.getElementById('All').style.display == 'none') {
            document.getElementById('All').style.display = 'block';
            document.getElementById('myDiv1').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('myDiv3').style.display = 'none';
            document.getElementById('searchDate').style.display = 'none';
        }
        else {
            document.getElementById('All').style.display = 'block';
            document.getElementById('myDiv1').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('searchDate').style.display = 'none';
        }
    }
}

function showOne() {
    if (document.getElementById('myDiv1')) {
        if (document.getElementById('myDiv1').style.display == 'none') {
            document.getElementById('myDiv1').style.display = 'block';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('All').style.display = 'none';
            document.getElementById('myDiv3').style.display = 'none';
            document.getElementById('searchDate').style.display = 'none';
        }
        else {
            document.getElementById('myDiv1').style.display = 'block';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('All').style.display = 'none';
            document.getElementById('searchDate').style.display = 'none';
        }
    }
}

function showTwo() {
    if (document.getElementById('myDiv2')) {
        if (document.getElementById('myDiv2').style.display == 'none') {
            document.getElementById('myDiv1').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'block';
            document.getElementById('All').style.display = 'none';
            document.getElementById('myDiv3').style.display = 'none';
            document.getElementById('searchDate').style.display = 'none';
        }
        else {
            document.getElementById('myDiv1').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'block';
            document.getElementById('myDiv3').style.display = 'none';
            document.getElementById('searchDate').style.display = 'none';
            document.getElementById('All').style.display = 'none';
        }
    }
}

function showThree() {
    if (document.getElementById('myDiv3')) {
        if (document.getElementById('myDiv3').style.display == 'none') {
            document.getElementById('myDiv1').style.display = 'none';
            document.getElementById('All').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('myDiv3').style.display = 'block';
            document.getElementById('searchDate').style.display = 'none';
        }
        else {
            document.getElementById('myDiv1').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('myDiv3').style.display = 'block';
            document.getElementById('All').style.display = 'none';
            document.getElementById('searchDate').style.display = 'none';
        }
    }
}

function showSearchDate() {
    if (document.getElementById('searchDate')) {
        if (document.getElementById('searchDate').style.display == 'none') {
            document.getElementById('myDiv1').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('All').style.display = 'none';
            document.getElementById('myDiv3').style.display = 'none';
            document.getElementById('searchDate').style.display = 'block';
        }
        else {
            document.getElementById('myDiv1').style.display = 'none';
            document.getElementById('myDiv2').style.display = 'none';
            document.getElementById('myDiv3').style.display = 'none';
            document.getElementById('All').style.display = 'none';
            document.getElementById('searchDate').style.display = 'block';
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
