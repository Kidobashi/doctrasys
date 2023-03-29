@extends('templates.admin')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div class="p-2">
                            <h3 class="mb-0">{{ __('Users') }}</h3>
                        </div>
                        <div class="p-2">
                            <button href="#" class="btn float-end btn-sm mb-0 text-white text-center" type="button" data-toggle="modal" data-target="#exampleModal" style="background:  #2AAA8A;">+&nbsp; Add User</button>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Office
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                       Role
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Creation Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $row)
                                <tr>
                                    <td class="ps-4">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="text-center">
                                        {{ $row->name }}
                                    </td>
                                    <td class="text-center">
                                        {{ $row->email }}
                                    </td>
                                    <td class="text-center">
                                        {{ $row->office->officeName }}
                                    </td>
                                    <td class="text-center">
                                        {{ $row->roles->implode('name', ', ') }}
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($row->created_at)->format('Y-m-d') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit user">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <span>
                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mb-0">
                                {{ $users->links('vendor.pagination.bootstrap-5') }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{ route('admin.addUser') }}">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control text-capitalize" id="name" name="name" required>
            </div>
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password">Re-enter Password</label>
                <input type="password" class="form-control" id="password" name="password_confirmation" required>
            </div>
            <div class="form-group">
                <label for="offices">Assign Office</label>
                <select class="form-control" id="offices" name="assignedOffice">
                  @foreach ($offices as $row)
                    <option value="{{ $row->id }}">{{ $row->officeName }}</option>
                  @endforeach
            </select>
            </div>
            <div class="form-group">
              <label for="roles">Roles</label>
              <select class="form-control" id="roles" name="roles[]">
                @foreach ($roles as $role)
                  <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn text-white" style="background:  #2AAA8A;">Add User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
