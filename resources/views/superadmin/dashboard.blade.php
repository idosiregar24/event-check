    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard Super Admin</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

        <style>
            body {
                background-color: #f5f7fa;
                font-family: 'Segoe UI', sans-serif;
            }

            .header-box {
                background: linear-gradient(135deg, #0d6efd, #4f8bff);
                padding: 25px;
                border-radius: 10px;
                color: #fff;
                margin-bottom: 30px;
            }

            .stat-card {
                border-radius: 12px;
                background: #fff;
                padding: 25px;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            }

            /* Responsive Fix untuk tombol */
            .btn-action {
                padding: 6px 10px;
                font-size: 12px;
                margin: 2px;
            }

            /* Menghindari kolom tabel melebar */
            td, th {
                vertical-align: middle;
                word-wrap: break-word;
            }

            /* Fix tampilan mobile */
            @media (max-width: 768px) {
                .header-box h2 {
                    font-size: 22px;
                }

                .header-box p {
                    font-size: 14px;
                }

                .stat-card h2 {
                    font-size: 26px;
                }

                .btn-action {
                    font-size: 11px;
                    padding: 5px 8px;
                }

                table {
                    font-size: 13px;
                }
            }
        </style>
    </head>

    <body class="p-3">

        <div class="container">

            <!-- Header Dashboard -->
            <div class="header-box shadow-sm">
                <h2 class="m-0 fw-bold">Dashboard Super Admin</h2>
                <p class="m-0">Pengelolaan Event & Admin</p>
            </div>

            <!-- Statistik -->
            <div class="stat-card mb-4 shadow-sm">
                <h5 class="mb-0">Total Event</h5>
                <h2 class="fw-bold text-primary mt-2">{{ $totalEvents }}</h2>
            </div>

            <!-- Event Terbaru -->
            <div class="card p-3 shadow-sm">
                <h4 class="mb-3 fw-bold">Event Terbaru</h4>

                @if ($recentEvents->isEmpty())
                    <p class="text-muted">Belum ada event yang terdaftar.</p>
                @else

                    <!-- WRAPPER SCROLL RESPONSIVE -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Event</th>
                                    <th>Tanggal</th>
                                    <th>Admin Event</th>
                                    <th>Link Registrasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($recentEvents as $index => $event)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $event->nama_event }}</td>
                                        <td>{{ $event->tanggal }}</td>

                                        <td>
                                            @if ($event->admins && $event->admins->count() > 0)
                                                @foreach ($event->admins as $admin)
                                                    <div>• {{ $admin->name }} ({{ $admin->email }})</div>
                                                @endforeach
                                            @else
                                                <span class="text-danger">Belum ada admin</span>
                                            @endif
                                        </td>

                                        <td style="word-break: break-all;">
                                            @php $guestLink = route('guest.form', ['event' => $event->id]); @endphp
                                            <a href="{{ $guestLink }}" target="_blank" class="text-primary">
                                                {{ $guestLink }}
                                            </a>
                                        </td>

                                        <td class="text-center">

                                            <a href="{{ route('superadmin.events.edit', $event->id) }}"
                                                class="btn btn-warning btn-sm btn-action">Edit</a>

                                            <a href="{{ route('superadmin.assignAdminForm', $event->id) }}"
                                                class="btn btn-primary btn-sm btn-action">Tambah Admin</a>

                                            <a href="{{ route('superadmin.generateQR', $event->id) }}" class="btn btn-primary btn-sm btn-action">Generate QR</a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @endif
            </div>

            <!-- Tombol Tambah Event -->
            <div class="mt-4 text-center">
                <a href="{{ route('superadmin.events.create') }}" class="btn btn-success px-4 py-2 fw-bold">
                    + Tambah Event Baru
                </a>
            </div>

        </div>
    </body>

    </html>
