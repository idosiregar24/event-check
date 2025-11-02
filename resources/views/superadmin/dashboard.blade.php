<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Super Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">
    <div class="container">
        <h2 class="mb-4">Dashboard Super Admin</h2>

        <div class="card mb-4 p-3 shadow-sm">
            <h5>Total Event: <strong>{{ $totalEvents }}</strong></h5>
        </div>

        <div class="card p-3 shadow-sm">
            <h4 class="mb-3">Event Terbaru</h4>

            @if ($recentEvents->isEmpty())
                <p class="text-muted">Belum ada event yang terdaftar.</p>
            @else
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Event</th>
                            <th>Tanggal</th>
                            <th>Admin Event</th>
                            <th>Link Registrasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentEvents as $index => $event)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $event->nama_event }}</td>
                                <td>{{ $event->tanggal }}</td>
                                <td>
                                    @if ($event->admins && $event->admins->count() > 0)
                                        @foreach ($event->admins as $admin)
                                            <div>{{ $admin->name }} ({{ $admin->email }})</div>
                                        @endforeach
                                    @else
                                        <span class="text-danger">Belum ada admin</span>
                                    @endif
                                </td>

                                {{-- Kolom Link Registrasi --}}
                                <td>
                                    @php
                                        $guestLink = route('guest.form', ['event' => $event->id]);
                                    @endphp
                                    <a href="{{ $guestLink }}" target="_blank">{{ $guestLink }}</a>
                                </td>

                                <td>
                                    <a href="{{ route('superadmin.events.edit', $event->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <a href="{{ route('superadmin.assignAdminForm', $event->id) }}"
                                        class="btn btn-sm btn-primary">Tambah Admin</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            @endif
        </div>

        <div class="mt-4">
            <a href="{{ route('superadmin.events.create') }}" class="btn btn-success">+ Tambah Event Baru</a>
        </div>
    </div>
</body>

</html>
