<!-- resources/views/emails/welcome_user.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang di Aplikasi Kami</title>
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
            <h1>Selamat Datang di Aplikasi Kami</h1>
        </div>
        <div class="content">
            <h2>Hallo, {{ $user->name }}!</h2>
            <p>Email Anda, {{ $user->email }}, telah ditambahkan sebagai pengguna oleh admin.</p>
            <p>Untuk melengkapi pendaftaran Anda, silakan buat password baru dengan mengklik tombol di bawah ini:</p>
            @if (Route::has('password.request'))
            <a class="btn" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
        @endif
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Aplikasi Kami. Seluruh hak cipta dilindungi.</p>
            <p>Jika Anda memiliki pertanyaan, jangan ragu untuk <a href="#">menghubungi kami</a>.</p>
        </div>
    </div>
</body>
</html>



<!-- konfigurasi tampilan untuk welcome user yang register melalui registrasi manual-->


