<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enableUserModalLabel">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="/reset-password/{{ $user->id }}">
                    @csrf
                <div class="form-group text-wrap">
                     Are you sure you want to reset the password for this user?
                    Enter the Adminisatrator password to confirm.
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
