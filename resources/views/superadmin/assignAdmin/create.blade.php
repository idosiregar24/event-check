<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Admin untuk Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Admin untuk Event</h4>
            </div>

            <div class="card-body">
                {{-- Flash Message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Event Info --}}
                <p><strong>Event:</strong> {{ $event->nama_event }}</p>
                <p><strong>Tanggal:</strong> {{ $event->tanggal }}</p>

                {{-- Form Tambah Admin Baru --}}
                {{-- Form Tambah Admin Baru --}}
                <form action="{{ route('superadmin.assignAdminStore', $event->id) }}" method="POST">
                    @csrf

                    {{-- Opsional: Pilih Admin yang Sudah Ada --}}
                    @if (count($admins) > 0)
                        <div class="mb-3">
                            <label for="admin_id" class="form-label">Pilih Admin yang Sudah Ada (Opsional)</label>
                            <select name="admin_id" id="admin_id"
                                class="form-select @error('admin_id') is-invalid @enderror">
                                <option value="">-- Pilih Admin --</option>
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->id }}"
                                        {{ old('admin_id') == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }} ({{ $admin->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('admin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                    @endif

                    {{-- Tambah Admin Baru --}}
                    <p class="fw-bold">Tambahkan Admin Baru:</p>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Admin</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Admin</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Admin</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('superadmin.events.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Tambahkan Admin</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
