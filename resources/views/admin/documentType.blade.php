@extends('templates.admin')

@section('content')
<div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div class="p-2">
                        <h3 class="mb-0">{{ __('Document Types') }}</h3>
                    </div>
                    <div class="p-2">
                         <button href="#" class="btn text-white float-end btn-sm mb-0 text-center" type="button" data-toggle="modal" data-target="#exampleModalCenter" style="background:  #2AAA8A;">+&nbsp; Add new document type</button>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4 p-3">
                <div class="row">
                    <div class="col-md-1 text-center"><h6>No</h6></div>
                    <div class="col-md-5"><h6>Name</h6></div>
                    <div class="col-md-1 text-center"><h6>Status</h6></div>
                    <div class="col-md-1 text-center"><h6>Action</h6></div>
                </div>
                @foreach ($docType as $row)
                <div class="row">
                    <div class="d-flex">
                        <div class="col-md-1 text-center">
                            {{ $loop->iteration }}
                        </div>
                        <div class="col-md-5">
                            <p style="white-space: normal;">{{ $row->docType }}</p>
                        </div>
                        <div class="col-md-1 text-center">
                            @if ($row->status == 1)
                                <span class="badge rounded-pill bg-primary">Active</span>
                            @else
                                <span class="badge rounded-pill bg-secondary">Inactive</span>
                            @endif
                        </div>
                        <div class="col-md-1 text-center">
                            @if ($row->status == 1)
                                <span>
                                    <form id="disable-doctype-{{ $row->id }}" class="disable-doctype-form" method="post" action="delDocType/{{ $row->id }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm disable-doctype-btn" style="background: #FF4C67; color: white;">Disable</button>
                                    </form>
                                </span>
                            @else
                            <span>
                                <form id="enable-doctype-{{ $row->id }}" class="enable-doctype-form" method="post" action="enableDocType/{{ $row->id }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm enable-doctype-btn" style="background: #2AAA8A; color: white;">Enable</button>
                                </form>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                <hr>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mb-0">
                        {{ $docType->links('vendor.pagination.bootstrap-5') }}
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
          <h5 class="modal-title mx-3 mt-3" id="exampleModalLongTitle">Add New Document Type<span class="text-danger">*</span></h5>
        <div class="modal-body">
          <form action="{{ route('admin.addDoctypes') }}" method="post">
            @csrf
            <input type="text" style="text-transform: capitalize;" class="form-control" name="docType" id="name" aria-label="Name" aria-describedby="name">
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
    $(document).on('click', '.disable-doctype-btn', function(event) {
         event.preventDefault();
         var form = $(this).closest('form');
         Swal.fire({
             title: "Are you sure?",
             text: "Users will not have access to this document type.",
             icon: "warning",
             showCancelButton: true,
             confirmButtonText: "Proceed",
             cancelButtonText: "Cancel",
             dangerMode: true,
         }).then((willProceed) => {
             if (willProceed.isConfirmed) {
                 form.submit();
                 Swal.fire({
                     text: "Document Type Disabled",
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

     $(document).on('click', '.enable-doctype-btn', function(event) {
         event.preventDefault();
         var form = $(this).closest('form');
         Swal.fire({
             title: "Are you sure?",
             text: "Users will have access to this document type.",
             icon: "warning",
             showCancelButton: true,
             confirmButtonText: "Proceed",
             cancelButtonText: "Cancel",
             dangerMode: true,
         }).then((willProceed) => {
             if (willProceed.isConfirmed) {
                 form.submit();
                 Swal.fire({
                     text: "Document Type Enabled",
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
