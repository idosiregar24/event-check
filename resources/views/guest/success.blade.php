<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container text-center">
        <h3>Registrasi Berhasil!</h3>
        <p>Halo {{ $guest->name }}, berikut QR Code Anda:</p>
        <div>{!! $qrCode !!}</div>
        <p><strong>Simpan QR Code ini untuk hadir di acara.</strong></p>
    </div>
</body>

</html>
