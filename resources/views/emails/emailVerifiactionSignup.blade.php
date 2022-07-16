<!DOCTYPE html>
<html>

<head>
  <title>Laravel 8 Send Email Example Verification</title>
</head>

<body>
  <h1>Email Verification Mail</h1>
  Hi {{$name}} Thank you for register, please verify your email with bellow link:
  <a href="{{ route('auth.verify', $token) }}">Verify Email</a>
</body>

</html>