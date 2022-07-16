<!DOCTYPE html>
<html>

<head>
  <title>Laravel 8 Send Email Reset Password</title>
</head>

<body>
  <h1>Reset Password Email</h1>
  Please use link below to reset your password:
  <a href="{{ route('auth.resetpassword', $token) }}">Reset Password</a>
</body>

</html>