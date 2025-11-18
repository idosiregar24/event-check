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

        <h2 style="color:#27ae60; margin-bottom:5px;">✓ Registrasi Berhasil</h2>
        <p style="margin-top:0;">Terima kasih, {{ $guest->name }}!</p>

        <p>Berikut adalah QR Code yang harus dibawa saat acara:</p>
        <div>{!! $qrCode !!}</div>

        <p style="margin-top:20px;"><strong>Simpan QR Code ini sebagai bukti registrasi.</strong></p>

        <hr style="margin:25px 0;">

        <p style="margin-top:20px; font-size:13px; color:#888;">
            Panitia Natal PMK PCR 2025
        </p>

    </div>
</body>

</html>
