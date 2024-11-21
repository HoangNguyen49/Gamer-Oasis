<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
            margin-top: 20px;
            text-align: center;
        }
        p {
            margin: 20px 0;
            text-align: center;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Hello, {{ $name }}</h1>
    <p>You have requested a password reset. Click the link below to reset your password:</p>
    <p><a href="{{ route('password.reset', ['email' => $email])}}">Reset Password</a></p>
</body>
</html>
