<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset Request</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>

    <p>You are receiving this email because we received a password reset request for your account.</p>

    <p>Please click the following link to reset your password:</p>

    <a href="{{ $resetUrl }}">Reset Password</a>

    <p>If you did not request a password reset, no further action is required.</p>

    <p>Thank you,</p>
    <p>Your Company Name</p>
</body>
</html>
