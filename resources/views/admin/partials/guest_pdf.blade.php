<!DOCTYPE html>
<html>
<head>
    <title>Daftar Tamu</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h3>Daftar Tamu Event: {{ $event->nama_event }}</h3>
    <p>Tanggal: {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Instansi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guests as $index => $guest)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $guest->name }}</td>
                    <td>{{ $guest->email }}</td>
                    <td>{{ $guest->instansi ?? '-' }}</td>
                    <td>{{ ucfirst($guest->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
