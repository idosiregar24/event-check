@if ($guests->isEmpty())
    <div class="alert alert-info">Belum ada tamu yang mendaftar.</div>
@else
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-primary text-dark">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Instansi</th>
                <th>No HP</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guests as $index => $guest)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $guest->name }}</td>
                    <td>{{ $guest->email }}</td>
                    <td>{{ $guest->instansi ?? '-' }}</td>
                    <td>{{ $guest->phone ?? '-' }}</td>
                    <td>
                        @if ($guest->status === 'hadir')
                            <span class="badge bg-success">Hadir</span>
                        @else
                            <span class="badge bg-secondary">Belum Hadir</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
