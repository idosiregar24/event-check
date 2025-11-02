<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            margin-top: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-card h3 {
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
        }

        .required:after {
            content: "*";
            color: red;
            margin-left: 3px;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="col-md-6 form-card">
            <h3>Registrasi Tamu</h3>
            <p class="text-muted mb-4">
                Event: <strong>{{ $event->nama_event }}</strong><br>
                Tanggal: {{ $event->tanggal }}
            </p>

            <form action="{{ route('guest.store', ['event' => $event->id]) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label required">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label required">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Instansi</label>
                    <input type="text" name="instansi" class="form-control" value="{{ old('instansi') }}">
                </div>

                <div class="mb-4">
                    <label class="form-label">No HP</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>

                <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </form>

        </div>
    </div>
</body>

</html>
