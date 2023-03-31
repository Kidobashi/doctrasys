<!-- Edit Modal -->
<div class="modal fade editModal" id="editModal{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-form" method="POST" action="{{ route('admin.update-user', $user->id) }}" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="assignedOffice">Assign Office</label>
                        <select class="form-control" id="assignedOffice" name="assignedOffice" required>
                            @foreach ($offices as $office)
                                <option value="{{ $office->id }}" @if($user->assignedOffice == $office->id) selected @endif>{{ $office->officeName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="roles">Roles</label>
                        <select class="form-control" id="roles" name="roles" required>
                          @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if($user->roles->implode('id', ', ') == $role->id) selected @endif>{{ $role->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <hr>
                      <div class="form-group">
                        <label for="password_confirmation">Administrator Password</label>
                        <input type="password" id="password2" name="check_password" autocomplete="off" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary"  id="saveBtn">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Edit Modal -->
