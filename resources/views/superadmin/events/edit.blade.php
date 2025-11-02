<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($event) ? 'Edit Event' : 'Tambah Event Baru' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <div class="container mt-4">
        <h2>{{ isset($event) ? 'Edit Event' : 'Create Event' }}</h2>

        <form action="{{ isset($event) ? route('superadmin.events.update', $event->id) : route('superadmin.events.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($event))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="nama_event" class="form-label">Nama Event</label>
                <input type="text" name="nama_event" id="nama_event" class="form-control"
                       value="{{ old('nama_event', $event->nama_event ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Event</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control"
                       value="{{ old('tanggal', $event->tanggal ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" class="form-control"
                       value="{{ old('lokasi', $event->lokasi ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $event->deskripsi ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar (Opsional)</label>
                <input type="file" name="gambar" id="gambar" class="form-control">

                @if(isset($event) && $event->gambar)
                    <p class="mt-2">Gambar saat ini:</p>
                    <img src="{{ asset('uploads/event/' . $event->gambar) }}" alt="Event" width="200" class="rounded shadow">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">
                {{ isset($event) ? 'Update Event' : 'Simpan Event' }}
            </button>

            <a href="{{ route('superadmin.events.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

</body>
</html>
