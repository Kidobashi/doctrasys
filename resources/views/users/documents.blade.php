
@extends('templates.user')
@section('content')
<style>

#filter, #myDiv2, #myDiv3, #myDiv1{
    display: none;
}

</style>
This page took {{ number_format((microtime(true) - LARAVEL_START),3)}} seconds to render
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
        <div class="container neomorphic-bg mb-2">
            <div class="bg-white">
                <div class="card">
                    <div class="grid-container d-flex col-md">
                        <div class="input-group p-3">
                            <span class="input-group-text" id="basic-addon1">Filter By:</span>
                            <input type="text" class="form-control" placeholder="Office, Date" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="dropdown show p-3">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filter by Status
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                              <a class="dropdown-item bg-primary text-white" href="{{ url('documents') }}" >All Documents</a>
                              <a class="dropdown-item bg-success text-white" onclick="showOne()" href="#">Completed</a>
                              <a class="dropdown-item bg-info text-white" onclick="showTwo()" href="#">Circulating</a>
                              <a class="dropdown-item bg-danger text-white" onclick="showThree()" href="#">Sent Back</button>
                              </div></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container neomorphic-bg">
            <div class="card bg-white">
                <div class="mx-3 my-1 p-2">
                    <a href="add-document"><button class="btn btn-success float-end" data-toggle="modal"><i class="fas fa-plus"></i></i></button></a>
                    <div class="card-header bg-white">
                        <h4>List of Documents</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" scope="col">No.</th>
                                    <th class="text-center" scope="col">Reference No.</th>
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
                                    <td class="text-center"> {{ $doc->officeName }}</td>
                                     @if ($doc->status == 3)
                                            <td><span class="badge bg-danger d-inline">Sent Back</span></td>
                                        @endif
                                        @if ($doc->status == 2)
                                            <td><span class="badge bg-success d-inline">Completed</span></td>
                                        @endif
                                        @if ($doc->status == 1)
                                        <td><span class="badge bg-info d-inline">Circulating</span></td>
                                    @endif
                                    <td class="text-center"><a href="{{ url('qrinfo/'.$doc->referenceNo) }}" title="Click for more Information"><i class="fa fa-link" aria-hidden="true"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="d-flex card-footer bg-white justify-content-center">
                    <div class="float-right">
                        {{ $all->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="height: 10%;">

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
