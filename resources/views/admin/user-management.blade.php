@extends('templates.admin')

@section('content')
<style>
    .pointer {cursor: pointer;}
    html, body {
        background-color:  #A0D6B4;
    }
    th, td {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
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
                    <div class="table-responsive p-1" style="width: 100%; overflow-x: auto;">
                        <table class="table mb-0 p-3">
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
                                        Status
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
                                @foreach($users as $user)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class=" text-center">
                                        {{ $user->name }}
                                    </td>
                                    <td class=" text-center">
                                        {{ $user->email }}
                                    </td>
                                    <td class=" text-center">
                                        {{ $user->office->officeName }}
                                    </td>
                                    <td class=" text-center">
                                        {{ $user->roles->implode('name', ', ') }}
                                    </td>
                                     <td class="text-center">
                                        @if ($user->status == 1)
                                            <span class="badge pill-rounded bg-success">Active</span>
                                        @else
                                            <span class="badge pill-rounded bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}
                                    </td>

                                    <td class="text-center d-flex">
                                        <div class="pointer mx-3">
                                            <button class="btn p-0" data-toggle="modal" data-target="#editModal{{ $user->id }}">
                                                <i title="Edit" type="button" class="p-2 fas fa-user-edit text-white bg-warning rounded"></i>
                                            </button>
                                        </div>
                                            <!-- Edit Modal -->
                                            @include('admin.modals.edit-user-modal', ['user' => $user])
                                        @if ($user->status == 1)
                                        <div class="pointer mx-3">
                                            <button class="btn p-0" type="submit" data-toggle="modal" data-target="#disableUserModal{{ $user->id }}">
                                                <i title="Disable" class="p-2 fas fa-ban text-white bg-danger rounded"></i>
                                            </button>
                                        </div>
                                        @else
                                        <div class="pointer mx-3">
                                                <button class="btn p-0" type="submit" data-toggle="modal" data-target="#enableUserModal{{ $user->id }}">
                                                    <i title="Enable" class="p-2 fas fa-thumbs-up text-white bg-success rounded"></i>
                                                </button>
                                        </div>
                                        @endif
                                        <div class="pointer mx-3">
                                            <button class="btn p-0">
                                                <i title="Reset password" class="p-2 fas fa-key text-white bg-primary rounded"></i>
                                            </button>
                                        </div>
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
            <hr>
            <div class="form-group px-5">
                <label for="password_confirmation">Administrator Password</label>
                <input type="password" id="password2" name="check_password" autocomplete="off" required>
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
<!-- Disable User Modal -->
<div class="modal fade" id="disableUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="disableUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disableUserModalLabel">Disable User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="disableUserForm" action="/disable-user/{{ $user->id }}">
                    @csrf
                Are you sure you want to disable this user? Enter administrator password.                <div class="form-group d-flex">
                    <input type="password" id="password2" name="check_password" autocomplete="off" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                {{-- <form method="POST" action="/disable-user/{{ $user->id }}" id="disableUserForm">
                    @csrf --}}
                    <button type="submit" class="btn btn-danger">Disable</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Enable User Modal -->
<div class="modal fade" id="enableUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="enableUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enableUserModalLabel">Enable User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to enable this user? Enter the Adminisatrator password
                <div class="form-group">
                    <input type="password" id="password2" name="check_password" autocomplete="off" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form method="POST" action="/enable-user/{{ $user->id }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Enable</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
