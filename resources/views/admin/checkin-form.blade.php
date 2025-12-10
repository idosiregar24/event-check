<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Kehadiran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
<div class="container mt-5">

    <h3>Konfirmasi Kehadiran</h3>

    <p>Nama Undangan: <strong>{{ $guest->nama_tamu }}</strong></p>
    <p>Event: <strong>{{ $guest->event->nama_event ?? '-' }}</strong></p>

    <label class="mt-3">Masukkan NIM:</label>

    <div class="input-group">
        <input type="text" id="nim" class="form-control" placeholder="NIM">
        <button class="btn btn-primary" id="btnCari">Cari</button>
    </div>

    <div id="hasil" class="mt-3" style="display:none;">
        <div class="alert alert-success">
            <p><strong>NIM ditemukan!</strong></p>
            <p>Nama: <span id="mhs_nama"></span></p>
            <p>Prodi: <span id="mhs_prodi"></span></p>
        </div>

        <form action="{{ route('checkin.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="guest_id" value="{{ $guest->id }}">
            <input type="hidden" name="nim" id="nim_hidden">

            <button class="btn btn-success w-100">
                ✔ Konfirmasi Kehadiran
            </button>
        </form>
    </div>

    <div id="error" class="alert alert-danger mt-3" style="display:none;">
        NIM tidak ditemukan.
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $("#btnCari").click(function() {
        let nim = $("#nim").val();

        $.post("{{ route('checkin.cariNim') }}", {
            nim: nim,
            _token: "{{ csrf_token() }}"
        }, function(res) {

            if (res.status === true) {
                $("#error").hide();
                $("#hasil").show();

                $("#mhs_nama").text(res.nama);
                $("#mhs_prodi").text(res.prodi);
                $("#nim_hidden").val(res.nim);
            } else {
                $("#hasil").hide();
                $("#error").show();
            }

        }, 'json');
    });
</script>

</body>
</html>
