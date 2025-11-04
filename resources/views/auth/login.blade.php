<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Event Check</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0056d2 0%, #6610f2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            color: #343a40;
        }

        .login-card {
            background: #fff;
            border-radius: 18px;
            padding: 2.2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 380px;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            width: 65px;
            height: 65px;
            object-fit: contain;
            display: block;
            margin: 0 auto 10px;
        }

        .login-title {
            text-align: center;
            font-weight: 600;
            color: #222;
        }

        .subtitle {
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0056d2, #6610f2);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #6610f2, #0056d2);
            transform: scale(1.03);
        }

        label {
            font-weight: 500;
            color: #495057;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
        }

        .alert {
            font-size: 0.9rem;
            padding: 0.6rem 1rem;
            border-radius: 8px;
        }

        .footer-text {
            text-align: center;
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 1.2rem;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Logo Event Check -->
        <img src="https://cdn-icons-png.flaticon.com/512/751/751463.png" alt="Event Check Logo" class="brand-logo">

        <!-- Judul & Identitas -->
        <h3 class="login-title">Event Check Login</h3>
        <p class="subtitle">Masuk untuk mengelola dan memantau aktivitas event Anda</p>

        <!-- Error Alert -->
        @if($errors->any())
            <div class="alert alert-danger text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Form Login -->
        <form action="/login" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control"
                    placeholder="Masukkan email kamu"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <button class="btn btn-primary w-100 py-2 mt-2" type="submit">Login</button>
        </form>

        <div class="footer-text">
            &copy; {{ date('Y') }} Ido Refael Siregar • Sistem Manajemen Kehadiran
        </div>
    </div>

</body>
</html>
