
@extends('templates.user')
@section('content')
<style>

#filter, #myDiv2, #myDiv3, #myDiv1{
    display: none;
}

</style>
{{-- This page took {{ number_format((microtime(true) - LARAVEL_START),3)}} seconds to render --}}
<div class="container-fluid mb-3 mt-1">
    <div class="row">
        <div class="col-md-12">
            <div class="my-3">
                <div class="row justify-content-between">
                    @isset($totalDoc)
                    <div class="col-md-2 m-auto p-3 levitating-div bg-white rounded">
                        <h2 class="font-weight-bolder mb-0">
                            {{ $totalDoc }}
                        </h2>
                        <p class="text-sm mb-0 text-capitalize">Documents Created</p>
                    </div>
                    @endisset
                    <div class="col-md-2 m-auto p-3 levitating-div bg-white rounded">
                        <h2 class="font-weight-bolder text-success mb-0">
                            {{ $totalApproved }}
                        </h2>
                        <p class="text-sm mb-0 text-capitalize">Approved</p>
                    </div>
                    <div class="col-md-2 m-auto p-3 levitating-div bg-white rounded">
                        <h2 class="font-weight-bolder text-primary mb-0">
                            {{ $totalProcessing }}
                        </h2>
                        <p class="text-sm mb-0 text-capitalize">Processing</p>
                    </div>
                    <div class="col-md-2 m-auto p-3 levitating-div bg-white rounded">
                        <h2 class="font-weight-bolder text-danger mb-0">
                            {{ $totalRejected }}
                        </h2>
                        <p class="text-sm mb-0 text-capitalize">Rejected</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (count($all) == '0')
    <p class="display-4">No documents found</p>
@elseif (isset($all) != 0)
    <div id="All">
        <div class="container neomorphic-bg mb-2">
            <div class="bg-white">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <form action="" class="search-form">
                                    @csrf
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Search</span>
                                        <input type="text" class="form-control" placeholder="Reference Number" name="search" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-9 d-flex justify-content-end">
                                <div class="col-md-2 d-flex m-auto">
                                    <select class="form-control col-md-1" id="officeDropdown" onchange="filterDocumentsByOffice()">
                                        <option value="all">Filter by Office</option>
                                        <option value="all">Unfilter</option>
                                        @foreach ($offices as $row)
                                            <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex m-auto">
                                    <select class="form-control col-md-1" id="documentTypeDropdown" onchange="filterDocumentsByDocumentType()">
                                    <option value="all">Filter by Document Type</option>
                                    <option value="all">Unfilter</option>
                                    @foreach ($allDocTypes as $row)
                                        <option value="{{ $row->id }}">{{ $row->docType }}</option>
                                        </option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex m-auto">
                                    <select class="form-control col-md-1" id="statusDropdown" onchange="filterDocumentsByStatus()">
                                        <option value="all">Filter by Status</option>
                                        <option value="all">Unfilter</option>
                                        <option value="1">Circulating</option>
                                        <option value="2">Received</option>
                                        <option value="3">Processing</option>
                                        <option value="4">Forwarded</option>
                                        <option value="5">Found Issue</option>
                                        <option value="6">Sent Back</option>
                                        <option value="7">Resolving Issue</option>
                                        <option value="8">Resubmitted</option>
                                        <option value="9">APPROVED and Kept</option>
                                        <option value="10">APPROVED</option>
                                        <option value="11">Rejected</option>
                                        <option value="12">Found Issue(by Recipient)</option>
                                    </select>
                                </div>
                                <li class="dropdown d-flex text-center">
                                    <button class="btn btn-primary p-1 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Sort by Date
                                    </button>
                                    <div class="dropdown-menu text-center">
                                        <p class="p-2"><a href="{{ route('documents-list', ['sort' => 'asc']) }}">Ascending<i class="fa fa-arrow-up"></i></a></p>
                                        <p class="p-2 mb-0"><a href="{{ route('documents-list', ['sort' => 'desc']) }}">Descending<i class="fa fa-arrow-down"></i></a></p>
                                    </div>
                                </li>
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
                                    <th class="text-center" scope="col">Recipient Office</th>
                                    <th class="text-center" scope="col">Document Type</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col">Details</th>
                                    <th class="text-center" scope="col">Creation Date</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                            @foreach ($all as $doc)
                                <tr data-office-name="{{ $doc->receiverOffice_id}}" data-document-type="{{ $doc->docType }}" data-status="{{ $doc->status }}">
                                    <td class="text-center"> {{ $loop->iteration }} </td>
                                    <td class="text-center"> {{ $doc->referenceNo }}</td>
                                    <td class="text-center"> {{ $doc->receiverOffice->officeName }}</td>
                                    <td class="text-center"> {{ $doc->documentType->docType }}</td>
                                    @if ($doc->status == 12)
                                    {{-- //rejected sent back --}}
                                        <td><span class="badge bg-danger d-inline">Found Issue (by Recipient)</span></td>
                                    @elseif ($doc->status == 11)
                                    {{-- //rejected --}}
                                        <td><span class="badge bg-secondary d-inline">REJECTED(IRREDEEMABLE)</span></td>
                                    @elseif ($doc->status == 10)
                                    {{-- //approved and return --}}
                                        <td><span class="badge bg-success d-inline">APPROVED</span></td>
                                    @elseif ($doc->status == 9)
                                    {{-- //approved and kept --}}
                                        <td><span class="badge bg-success d-inline">APPROVED and Kept</span></td>
                                    @elseif ($doc->status ==8)
                                    {{-- //resubmitted --}}
                                        <td><span class="badge d-inline" style="background-color: rgb(48, 48, 185);">Resubmitted</span></td>
                                    @elseif ($doc->status == 7)
                                    {{-- //resolved --}}
                                        <td><span class="badge bg-warning d-inline">Resolving Issue</span></td>
                                    @elseif ($doc->status == 6)
                                    {{-- //returned --}}
                                        <td><span class="badge bg-secondary d-inline">Sent Back</span></td>
                                    @elseif ($doc->status == 5)
                                    {{-- //rejected sent back to --}}
                                        <td><span class="badge bg-danger d-inline">Found Issue</span></td>
                                    @elseif ($doc->status == 4)
                                    {{-- //forwarded --}}
                                        <td><span class="badge bg-success d-inline">Forwarded</span></td>
                                    @elseif ($doc->status == 3)
                                    {{-- //process --}}
                                        <td><span class="badge bg-warning d-inline">Processing</span></td>
                                    @elseif ($doc->status == 2)
                                    {{-- //received --}}
                                        <td><span class="badge bg-primary d-inline">Received</span></td>
                                    @elseif ($doc->status == 1)
                                        <td><span class="badge bg-info d-inline">Circulating</span></td>
                                    @endif
                                    <td class="text-center"><a href="{{ url('qrinfo/'.$doc->referenceNo) }}" title="Click for more Information"><i class="fa fa-link" aria-hidden="true"></i></a></td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($doc->created_at)->format('Y-m-d')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="d-flex card-footer bg-white justify-content-center">
                    <div class="float-right">
                        {{ $all->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="height: 10%;">

    </div>
@endif

<script>
// JavaScript function to filter the list of documents by office
function filterDocumentsByOffice() {
  // Get the selected office from the dropdown
  var selectedOffice = document.getElementById("officeDropdown").value;

  // Get the table body element
  var tableBody = document.getElementById("table-body");

  // Get all the table rows
  var rows = tableBody.getElementsByTagName("tr");

  // Loop through each row
  for (var i = 0; i < rows.length; i++) {
    var row = rows[i];

    // Get the office name associated with the row
    var rowOfficeName = row.getAttribute("data-office-name");

    // Check if the row's office name matches the selected office
    if (selectedOffice === "all" || rowOfficeName === selectedOffice) {
      // Show the row
      row.style.display = "";
    } else {
      // Hide the row
      row.style.display = "none";
    }
  }
}

function filterDocumentsByDocumentType() {
  // Get the selected document type from the dropdown
  var selectedDocumentType = document.getElementById("documentTypeDropdown").value;

  // Get the table body element
  var tableBody = document.getElementById("table-body");

  // Get all the table rows
  var rows = tableBody.getElementsByTagName("tr");

  // Loop through each row
  for (var i = 0; i < rows.length; i++) {
    var row = rows[i];

    // Get the document type associated with the row
    var rowDocumentType = row.getAttribute("data-document-type");

    // Check if the row's document type matches the selected document type
    if (selectedDocumentType === "all" || rowDocumentType === selectedDocumentType) {
      // Show the row
      row.style.display = "";
    } else {
      // Hide the row
      row.style.display = "none";
    }
  }
}

// JavaScript function to filter the list of documents by status
function filterDocumentsByStatus() {
  // Get the selected status from the dropdown
  var selectedStatus = document.getElementById("statusDropdown").value;

  // Get the table body element
  var tableBody = document.getElementById("table-body");

  // Get all the table rows
  var rows = tableBody.getElementsByTagName("tr");

  // Loop through each row
  for (var i = 0; i < rows.length; i++) {
    var row = rows[i];

    // Get the status associated with the row
    var rowStatus = row.getAttribute("data-status");

    // Check if the row's status matches the selected status
    if (selectedStatus === "all" || rowStatus === selectedStatus) {
      // Show the row
      row.style.display = "";
    } else {
      // Hide the row
      row.style.display = "none";
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
