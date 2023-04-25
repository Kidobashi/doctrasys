@extends('templates.admin')

@section('content')
<style>
      html, body {
        background-color:  #A0D6B4;
    }
</style>
<div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div class="p-2">
                        <h3 class="mb-0">{{ __('Offices') }}</h3>
                    </div>
                    <div class="p-2">
                        <button href="#" class="btn float-end btn-sm mb-0 text-white text-center" type="button" data-toggle="modal" data-target="#exampleModalCenter" style="background:  #2AAA8A;">+&nbsp; Add New Office</button>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4 p-3">
                <div class="row">
                    <div class="col-md-1 text-center"><h6>No</h6></div>
                    <div class="col-md-5"><h6>Name</h6></div>
                    <div class="col-md-1 text-center"><h6>Status</h6></div>
                    <div class="col-md-2 text-center"><h6>Action</h6></div>
                </div>
                @foreach ($offices as $row)
                <div class="row">
                    <div class="d-flex">
                        <div class="col-md-1 text-center">
                            {{ $loop->iteration }}
                        </div>
                        <div class="col-md-5">
                            <p style="white-space: normal;">{{ $row->officeName }}</p>
                        </div>
                        <div class="col-md-1 text-center">
                            @if ($row->status == 1)
                                <span class="badge rounded-pill bg-primary">Active</span>
                            @else
                                <span class="badge rounded-pill bg-secondary">Disabled</span>
                            @endif
                        </div>
                        <div class="col-md-1 text-center">
                            @if ($row->status == 1)
                                <span>
                                    <form id="disable-office-{{ $row->id }}" class="disable-office-form" method="post" action="delOffice/{{ $row->id }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm disable-office-btn" style="background: #FF4C67; color: white;">Disable</button>
                                    </form>
                                </span>
                            @else
                            <span>
                                <form id="enable-office-{{ $row->id }}" class="enable-office-form" method="post" action="enableOffice/{{ $row->id }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm enable-office-btn" style="background: #2AAA8A; color: white;">Enable</button>
                                </form>
                            </span>
                            @endif
                        </div>
                        <div class="col-md-1 text-center">
                            <button class="btn p-0" data-toggle="modal" data-target="#editOfficeModal{{ $row->id }}">
                                <i title="Edit" type="button" class="p-2 fas fa-user-edit text-white bg-warning rounded"></i>
                            </button>
                        </div>
                            <!-- Edit Modal -->
                            @include('admin.modals.edit-office-modal', ['row' => $row])
                    </div>
                </div>
                @endforeach
                <hr>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mb-0">
                        {{ $offices->links('vendor.pagination.bootstrap-5') }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <h5 class="modal-title mx-3 mt-3" id="exampleModalLongTitle">Add New Office<span class="text-danger">*</span></h5>
        <div class="modal-body">
          <form action="/addOffice" method="post">
            @csrf
            <input type="text" style="text-transform: capitalize;" class="form-control" name="officeName" id="name" aria-label="Name" aria-describedby="name">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
        </div>
      </div>
    </div>
  </div>

<script>
   $(document).on('click', '.disable-office-btn', function(event) {
        event.preventDefault();
        var form = $(this).closest('form');
        Swal.fire({
            title: "Are you sure?",
            text: "Users will not have access to this office.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Proceed",
            cancelButtonText: "Cancel",
            dangerMode: true,
        }).then((willProceed) => {
            if (willProceed.isConfirmed) {
                form.submit();
                Swal.fire({
                    text: "Office Disabled",
                    icon: "success",
                });
            } else {
                Swal.fire({
                    text: "No changes made.",
                    icon: "error",
                });
            }
        });
    });

    $(document).on('click', '.enable-office-btn', function(event) {
        event.preventDefault();
        var form = $(this).closest('form');
        Swal.fire({
            title: "Are you sure?",
            text: "Users will have access to this office.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Proceed",
            cancelButtonText: "Cancel",
            dangerMode: true,
        }).then((willProceed) => {
            if (willProceed.isConfirmed) {
                form.submit();
                Swal.fire({
                    text: "Office Enabled",
                    icon: "success",
                });
            } else {
                Swal.fire({
                    text: "No changes made.",
                    icon: "error",
                });
            }
        });
    });
  </script>
@endsection
