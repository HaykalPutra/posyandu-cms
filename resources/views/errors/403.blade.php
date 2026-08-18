<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Ditolak - Posyandu Kita</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Manrope, Segoe UI, sans-serif;
            color: #16352a;
            background: radial-gradient(circle at 0% 0%, rgba(159, 51, 68, 0.14), transparent 34%), linear-gradient(135deg, #fbeef0, #f7fbfd 60%, #eef7f5);
            padding: 24px;
            text-align: center;
        }
        .code { font-size: 84px; font-weight: 800; color: #9c3344; margin: 0; }
        h1 { margin: 8px 0 12px; font-size: 24px; }
        p { color: #5d7b6c; margin: 0 0 24px; }
        a {
            display: inline-block;
            background: #1f7a53;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            padding: 12px 22px;
            border-radius: 999px;
        }
    </style>
</head>
<body>
    <div>
        <p class="code">403</p>
        <h1>Akses Ditolak</h1>
        <p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url('/') }}">Kembali ke Beranda</a>
    </div>
</body>
</html>
