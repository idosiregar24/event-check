<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Event Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

    <div class="container">
        <h2 class="mb-4">Tambah Event Baru</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('superadmin.events.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama_event" class="form-label">Nama Event</label>
                <input type="text" class="form-control" id="nama_event" name="nama_event"
                    value="{{ old('nama_event') }}" placeholder="Contoh: Natal PMK PCR 2025" required>
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Event</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi"
                    value="{{ old('lokasi') }}" placeholder="Gedung Serbaguna Kampus" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"
                    placeholder="Tuliskan deskripsi singkat acara...">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('superadmin.events.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Event</button>
            </div>
        </form>
    </div>

</body>
</html>
