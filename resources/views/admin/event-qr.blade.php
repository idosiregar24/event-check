<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container text-center mt-5">
    <h3>QR Code Event: {{ $guest->nama_event }}</h3>
    <p>Scan QR ini untuk melakukan check-in</p>

    <div class="mt-4">
        {!! $qrCode !!}
    </div>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-4">Kembali</a>
</div>

</body>
</html>
