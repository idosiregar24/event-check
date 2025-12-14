<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>QR Code Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light py-5">

    <div class="container text-center">

        <div class="card shadow p-4 mx-auto" style="max-width: 450px;">
            <h4 class="mb-3">QR Code Registrasi Event</h4>

            <p class="text-muted" style="word-break: break-all;">{{ $url }}</p>

            <div class="mb-3">
                {!! $qrCode !!}
            </div>

            <a href="{{ route('superadmin.downloadQR', $id) }}" class="btn btn-success w-100">
                ⤓ Download SVG
            </a>

            <a href="{{ url()->previous() }}" class="btn btn-secondary w-100 mt-2">
                ← Kembali
            </a>
        </div>

    </div>

</body>
</html>
