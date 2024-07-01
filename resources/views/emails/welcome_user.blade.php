<!-- resources/views/emails/welcome_user.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Application</title>
    <style type="text/css">
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f6f6f6;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #f6f6f6;
            color: #666666;
            padding: 10px;
            text-align: center;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Our Application</h1>
        </div>
        <div class="content">
            <h2>Hello, {{ $user->name }}!</h2>
            <p>Thank you for registering with us. You are now part of our community.</p>
            <a href="{{ route('dashboard') }}" class="btn">Go to Dashboard</a>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Our Application. All rights reserved.</p>
            <p>If you have any questions, feel free to <a href="">contact us</a>.</p>
        </div>
    </div>
</body>
</html>


<!-- konfigurasi tampilan untuk welcome user yang register melalui registrasi manual-->


