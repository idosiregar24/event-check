<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Event</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
  <h2>Daftar Event</h2>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('superadmin.events.create') }}" class="btn btn-success mb-3">+ Tambah Event</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th><th>Nama</th><th>Tanggal</th><th>Lokasi</th><th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($events as $e)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $e->nama_event }}</td>
          <td>{{ $e->tanggal }}</td>
          <td>{{ $e->lokasi }}</td>
          <td>
            <a href="{{ route('superadmin.events.edit', $e->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('superadmin.events.destroy', $e->id) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus event ini?')">Hapus</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
