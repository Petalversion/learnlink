<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Link</title>
</head>

<body>
    <p>Hello,</p>
    <p>You requested a password reset. Click the link below to reset your password:</p>
    <a href="{{ $link }}">{{ $link }}</a>
    <p>If you did not request a password reset, no further action is required.</p>
</body>

</html>