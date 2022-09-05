@extends('layouts.user_type.auth')

@section('content')
<div>
    <div class="container-fluid py-4">
        <div class="card">
            {{-- <div class="col-xxs-6 col-xs-4">
                @if(session()->has('success'))
                    <div id="message" class="col-lg-5 bg-success rounded right-3 text-sm py-2 px-4">
                        <h5 class="m-0">{{ session('success')}}</h5>
                    </div>
                @endif
            <div> --}}
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h3 class="mb-0">{{ __('Central Mindanao University Document Types') }}</h3>
                    </div>
                    <a href="#" class="btn bg-gradient-primary float-end btn-sm mb-0 text-center" type="button" data-toggle="modal" data-target="#exampleModalCenter">+&nbsp; Add new document type</a>
                </div>
            </div>
            <div class="card-body pt-4 p-3">
                @foreach ($docType as $row)
                <div class="d-flex">
                <p style="white-space: normal;">{{ $row->documentName }}</p>
                    <div class="">
                        <a href="#" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                            <i class="fas fa-user-edit text-secondary"></i>
                        </a>
                        <span>
                            <span>
                                <form method="post" action="delDocType/{{ $row->id }}">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </span>
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add New Document Type</h5>
        </div>
        <div class="modal-body">
          <form action="/addDocType" method="post">
            @csrf
            Name of Document Type
            <input type="text" class="form-control" name="documentName" id="name" aria-label="Name" aria-describedby="name">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
        </div>
      </div>
    </div>
  </div>
@endsection
