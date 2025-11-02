<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tamu Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <div class="container my-5">
        <h3>Daftar Tamu Event: <strong>{{ $event->nama_event }}</strong></h3>
        <p class="text-muted">Tanggal: {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</p>


        {{-- Input Pencarian --}}
        <div class="mb-3">
            <input type="text" id="search" class="form-control" placeholder="Cari nama, email, instansi...">
        </div>

        {{-- Container untuk partial guest seats --}}
        <div id="guestTable">
            @include('admin.partials.guest_seats', ['guests' => $guests])
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fungsi untuk load data tamu
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
                    },
                    error: function() {
                        console.log('Terjadi kesalahan saat memuat data.');
                    }
                });
            }

            // Auto-refresh setiap 10 detik
            setInterval(function() {
                let currentQuery = $('#search').val();
                loadGuests(currentQuery);
            }, 50000); // 5 detik

            // Event keyup search
            $('#search').on('keyup', function() {
                let query = $(this).val();
                loadGuests(query);
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

</body>

</html>
