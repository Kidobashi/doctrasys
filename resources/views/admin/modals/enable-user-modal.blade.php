<div class="modal fade" id="enableUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="enableUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enableUserModalLabel">Enable <em>{{ $user->name }}</em></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="/enable-user/{{ $user->id }}">
                    @csrf
                <div class="form-group text-wrap">
                    Confirm action by entering <em><strong>Adminisatrator</strong></em> password
                </div>
                <input type="password" id="password2" name="check_password" autocomplete="off" required>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Enable</button>
                </form>
            </div>
        </div>
    </div>
</div>
