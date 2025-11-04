<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tamu Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Library untuk QR Code -->
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
        #reader {
            width: 100%;
            max-width: 350px;
            margin: auto;
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>

<body>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3>Daftar Tamu Event: <strong>{{ $event->nama_event }}</strong></h3>
                <p class="text-muted">Tanggal: {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</p>
            </div>

            <!-- Tombol buka kamera scan -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#scanModal">
                📷 Scan QR Tamu
            </button>
        </div>

        {{-- Input Pencarian --}}
        <div class="mb-3">
            <input type="text" id="search" class="form-control" placeholder="Cari nama, email, instansi...">
        </div>

        {{-- Container untuk partial guest seats --}}
        <div id="guestTable">
            @include('admin.partials.guest_seats', ['guests' => $guests])
        </div>
    </div>

    <!-- Modal Scan -->
    <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="scanModalLabel">Scan QR Kehadiran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="reader"></div>
                    <div id="scanResult" class="mt-3"></div>
                    <small class="text-muted d-block mt-2">Pastikan izin kamera diaktifkan di browser Anda.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi refresh daftar tamu
        $(document).ready(function() {
            function loadGuests(query = '') {
                $.ajax({
                    url: "{{ route('admin.events.guests', $event->id) }}",
                    type: 'GET',
                    data: {
                        search: query
                    },
                    success: function(data) {
                        $('#guestTable').fadeOut(100, function() {
                            $(this).html(data).fadeIn(200);
                        });
                    }
                });
            }

            setInterval(() => {
                loadGuests($('#search').val());
            }, 50000);

            $('#search').on('keyup', function() {
                loadGuests($(this).val());
            });
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    let html5QrCode;
    const scanModal = document.getElementById('scanModal');

    scanModal.addEventListener('shown.bs.modal', async function() {
        const readerElem = document.getElementById("reader");
        const resultElem = document.getElementById("scanResult");
        resultElem.innerHTML = "";

        html5QrCode = new Html5Qrcode("reader");

        try {
            const cameras = await Html5Qrcode.getCameras();

            if (!cameras.length) {
                resultElem.innerHTML = `<div class="alert alert-danger">Tidak ada kamera terdeteksi di perangkat ini.</div>`;
                return;
            }

            // Coba pakai kamera belakang kalau tersedia
            const backCam = cameras.find(cam => cam.label.toLowerCase().includes("back")) || cameras[0];

            await html5QrCode.start(
                { deviceId: { exact: backCam.id } },
                {
                    fps: 10,
                    qrbox: 250,
                    facingMode: "environment"
                },
                (decodedText) => {
                    resultElem.innerHTML = `<div class="alert alert-success">Kode terbaca: <b>${decodedText}</b></div>`;
                    html5QrCode.stop().then(() => html5QrCode.clear());
                },
                (errorMessage) => {
                    // ignore read errors
                }
            );

        } catch (err) {
            console.error(err);
            resultElem.innerHTML = `<div class="alert alert-danger">⚠️ Gagal membuka kamera.<br>Pastikan:
            <ul class="text-start">
                <li>Izin kamera diizinkan untuk situs ini.</li>
                <li>Situs diakses melalui <b>HTTPS</b> atau <b>localhost</b>.</li>
            </ul></div>`;
        }
    });

    // Hentikan kamera saat modal ditutup
    scanModal.addEventListener('hidden.bs.modal', function() {
        if (html5QrCode) {
            html5QrCode.stop().then(() => html5QrCode.clear());
        }
    });
});
</script>
</body>
