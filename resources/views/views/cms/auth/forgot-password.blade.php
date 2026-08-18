<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - CMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #eef8f5;
            --surface: #ffffff;
            --surface-soft: #f6fbf8;
            --line: #d4e4db;
            --ink: #16352a;
            --muted: #5d7b6c;
            --brand: #1f7a53;
            --brand-dark: #175c3e;
            --brand-soft: #dff3e8;
            --danger-bg: #fdecee;
            --danger-text: #9c3344;
            --success-bg: #e7f4eb;
            --success-text: #1f5f40;
            --shadow: 0 24px 60px rgba(18, 61, 42, 0.14);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--ink);
            font-family: Manrope, Segoe UI, sans-serif;
            background:
                radial-gradient(circle at 0% 0%, rgba(31, 122, 83, 0.18), transparent 34%),
                radial-gradient(circle at 100% 12%, rgba(86, 166, 190, 0.14), transparent 28%),
                linear-gradient(135deg, #edf8f4, #f7fbfd 60%, #eef7f5);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 16px;
        }

        .shell {
            width: min(460px, 100%);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(212, 228, 219, 0.88);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .box { padding: 30px 24px; }

        h2 {
            margin: 0;
            font-size: 30px;
            line-height: 1.1;
            font-family: Fraunces, Georgia, serif;
        }

        p.desc {
            margin: 10px 0 0;
            color: var(--muted);
            font-size: 15px;
        }

        .err, .ok {
            margin-top: 18px;
            border-radius: 14px;
            padding: 11px 13px;
            font-size: 14px;
            font-weight: 700;
        }

        .err { color: var(--danger-text); background: var(--danger-bg); border: 1px solid #f7d3d8; }
        .ok { color: var(--success-text); background: var(--success-bg); border: 1px solid #cdeada; }

        form { margin-top: 22px; }

        label {
            display: block;
            margin: 14px 0 8px;
            font-size: 13px;
            font-weight: 800;
            color: #335748;
        }

        input {
            width: 100%;
            border: 1px solid var(--line);
            background: var(--surface-soft);
            border-radius: 14px;
            padding: 13px 14px;
            font: 600 15px/1.4 Manrope, sans-serif;
            color: var(--ink);
            outline: none;
        }

        button {
            width: 100%;
            border: none;
            border-radius: 14px;
            margin-top: 18px;
            padding: 13px 16px;
            background: linear-gradient(135deg, var(--brand), #24855b);
            color: #fff;
            font: 800 15px/1.2 Manrope, sans-serif;
            cursor: pointer;
        }

        .back { display: block; margin-top: 16px; text-align: center; font-size: 13px; color: var(--brand-dark); font-weight: 700; }
    </style>
</head>
<body>
    <div class="shell">
        <section class="box">
            <h2>Lupa Password</h2>
            <p class="desc">Masukkan email admin yang terdaftar. Kami akan mengirim link untuk membuat password baru.</p>

            @if (session('success'))
                <div class="ok">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="err">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <label>Email Admin</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                <button type="submit">Kirim Link Reset</button>
            </form>

            <a class="back" href="{{ route('cms.login') }}">Kembali ke Login</a>
        </section>
    </div>
</body>
</html>
