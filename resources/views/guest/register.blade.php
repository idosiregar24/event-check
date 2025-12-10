<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            margin-top: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-card h3 {
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
        }

        .required:after {
            content: "*";
            color: red;
            margin-left: 3px;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="col-md-6 form-card">
            <h3>Registrasi Tamu</h3>
            <p class="text-muted mb-4">
                Event: <strong>{{ $event->nama_event }}</strong><br>
                Tanggal: {{ $event->tanggal }}
            </p>

            <form action="{{ route('guest.store', ['event' => $event->id]) }}" method="POST">
                @csrf

                <!-- Nama -->
                <div class="mb-4">
                    <label class="form-label required">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="form-label required">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <!-- Generasi -->
                <div class="mb-4">
                    <label class="form-label required">Generasi</label>
                    <select name="generasi" class="form-select" required>
                        <option value="" disabled selected>Pilih Generasi</option>
                        <option value="22" {{ old('generasi')=='22' ? 'selected':'' }}>22</option>
                        <option value="23" {{ old('generasi')=='23' ? 'selected':'' }}>23</option>
                        <option value="24" {{ old('generasi')=='24' ? 'selected':'' }}>24</option>
                        <option value="25" {{ old('generasi')=='25' ? 'selected':'' }}>25</option>
                        <option value="alumni" {{ old('generasi')=='alumni' ? 'selected':'' }}>Alumni</option>

                    </select>
                </div>

                <!-- Program Studi -->
                <div class="mb-4">
                    <label class="form-label required">Program Studi</label>
                    <select name="program_studi" class="form-select" required>
                        <option value="" disabled selected>Pilih Program Studi</option>

                        <optgroup label="Jurusan Teknologi Informasi">
                            <option>Teknik Informatika</option>
                            <option>Sistem Informasi</option>
                            <option>Teknologi Rekayasa Komputer</option>
                            <option>Teknologi Rekayasa Sistem Elektronika</option>
                            <option>Teknologi Rekayasa Jaringan Telekomunikasi</option>
                            <option>Magister Terapan Teknik Komputer</option>
                        </optgroup>

                        <optgroup label="Jurusan Bisnis dan Komunikasi">
                            <option>Akuntansi Perpajakan</option>
                            <option>Komunikasi Digital</option>
                            <option>Bisnis Digital</option>
                        </optgroup>

                        <optgroup label="Jurusan Teknik">
                            <option>Teknik Mesin</option>
                            <option>Teknologi Rekayasa Mekatronika</option>
                            <option>Teknik Elektronika</option>
                        </optgroup>

                    </select>
                </div>

                <!-- Instansi -->
                <div class="mb-4">
                    <label class="form-label">Instansi</label>
                    <input type="text" name="instansi" class="form-control" value="{{ old('instansi') }}">
                </div>

                <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </form>

        </div>
    </div>
</body>

</html>
