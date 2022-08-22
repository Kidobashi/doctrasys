@extends('layouts.user_type.auth')

@section('content')
<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h3 class="mb-0">{{ __('Central Mindanao University Offices') }}</h3>
                    </div>
                    <a href="#" class="btn bg-gradient-primary float-end btn-sm mb-0 text-center" type="button" data-toggle="modal" data-target="#exampleModalCenter">+&nbsp; Add new office</a>
                </div>
            </div>
            <div class="card-body pt-4 p-3">
                @foreach ($offices as $row)
                <div class="d-flex">
                <p style="white-space: normal;">{{ $row->officeName }}</p>
                    <div class="">
                        <a href="#" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                            <i class="fas fa-user-edit text-secondary"></i>
                        </a>
                        <span>
                            <i class="cursor-pointer fas fa-trash text-secondary" data-bs-toggle="tooltip"  data-bs-original-title="Delete Office"></i>
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
          <h5 class="modal-title" id="exampleModalLongTitle">Add New Office</h5>
        </div>
        <div class="modal-body">
          <form action="/addOffice" method="post">
            @csrf
            Name of Office
            <input type="text" class="form-control" name="officeName" id="name" aria-label="Name" aria-describedby="name">
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
