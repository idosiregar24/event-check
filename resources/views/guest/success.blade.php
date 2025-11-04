<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Undian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 40px;
        }

        .container {
            display: inline-block;
            border: 1px solid #ddd;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .code-box {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            letter-spacing: 2px;
            background: #f1f1f1;
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Registrasi Berhasil!</h3>
        <p>Halo {{ $guest->name }}, berikut QR Code Anda:</p>
        <div>{!! $qrCode !!}</div>
        <p><strong>Simpan QR Code ini untuk hadir di acara.</strong></p>
        <hr>
        <p><strong>Kode Undian Anda:</strong></p>
        <div style="font-size:28px; font-weight:bold; letter-spacing:2px; color:#2c3e50;">
            {{ $guest->kode_undian }}
        </div>
    </div>
</body>

</html>
