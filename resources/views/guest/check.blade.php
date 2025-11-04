<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f9fc;
            text-align: center;
            margin: 0;
            padding: 40px 10px;
        }

        .container {
            display: inline-block;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 30px 40px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            max-width: 420px;
        }

        h3 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #2c3e50;
        }

        p {
            margin: 6px 0;
            color: #555;
            font-size: 15px;
        }

        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 15px 0;
        }

        .code-box {
            font-size: 26px;
            font-weight: bold;
            color: #2c3e50;
            letter-spacing: 2px;
            background: #f1f1f1;
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
            margin-top: 5px;
        }

        .success {
            color: #000000;
            font-weight: bold;
        }

        .warning {
            color: #ffc107;
            font-weight: bold;
        }

        .error {
            color: #dc3545;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            font-size: 14px;
        }

        .btn:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">

        @if ($status == 'success')
            <h3 class="success">Absensi Berhasil!</h3>
            <p>Halo <strong>{{ $guest->name }}</strong>, kehadiran Anda telah tercatat.</p>
            <hr>
            <p><strong>Kode Undian Anda:</strong></p>
            <div class="code-box">{{ $guest->kode_undian }}</div>
            <p style="margin-top:10px;">Waktu Absen: {{ $guest->updated_at->format('d M Y, H:i') }}</p>


        @elseif ($status == 'warning')
            <h3 class="warning">Sudah Terdaftar Hadir</h3>
            <p>Halo <strong>{{ $guest->name }}</strong>, Anda sudah melakukan absensi sebelumnya.</p>
            <hr>
            <p><strong>Kode Undian Anda:</strong></p>
            <div class="code-box">{{ $guest->kode_undian }}</div>
            <p style="margin-top:10px;">Terakhir Absen: {{ $guest->updated_at->format('d M Y, H:i') }}</p>


        @else
            <h3 class="error">Absensi Gagal</h3>
            <p>{{ $message }}</p>
        @endif

        <hr>
        <a href="{{ url('/') }}" class="btn">← Kembali ke Beranda</a>
    </div>
</body>

</html>
