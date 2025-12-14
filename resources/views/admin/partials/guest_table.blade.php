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
                    <th>Asal Tamu</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guests as $index => $guest)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $guest->name }}</td>
                        <td>{{ $guest->email }}</td>
                        <td>{{ $guest->instansi ?? '-' }}</td>
                        <td>
                            @if ($guest->status === 'hadir')
                                <span class="badge bg-success">Hadir</span>
                            @else
                                <span class="badge bg-secondary">Belum Hadir</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info btn-detail" data-bs-toggle="modal"
                                data-bs-target="#guestModal" data-name="{{ $guest->name }}"
                                data-email="{{ $guest->email }}" data-asal="{{ $guest->asal_tamu }}"
                                data-instansi="{{ $guest->instansi }}" data-generasi="{{ $guest->generasi }}"
                                data-prodi="{{ $guest->program_studi }}" data-status="{{ $guest->status }}">
                                Lihat Informasi
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>


        </table>
        <div class="modal fade" id="guestModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Informasi Tamu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama</th>
                                <td id="m-name"></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td id="m-email"></td>
                            </tr>
                            <tr>
                                <th>Asal Tamu</th>
                                <td id="m-asal"></td>
                            </tr>
                            <tr>
                                <th>Instansi</th>
                                <td id="m-instansi"></td>
                            </tr>
                            <tr>
                                <th>Generasi</th>
                                <td id="m-generasi"></td>
                            </tr>
                            <tr>
                                <th>Program Studi</th>
                                <td id="m-prodi"></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td id="m-status"></td>
                            </tr>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endif
