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

                <!-- Tipe Peserta -->
                <div class="mb-4">
                    <label class="form-label required">Asal Tamu</label>
                    <select name="asal_tamu" id="tipe_peserta" class="form-select" required>
                        <option value="" disabled selected>Pilih Tipe Peserta</option>
                        <option value="mahasiswa_pcr">Mahasiswa PCR</option>
                        <option value="tamu">Tamu</option>
                    </select>
                </div>


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
                <div class="mb-4" id="field-generasi">
                    <label class="form-label required">Generasi</label>
                    <select name="generasi" id="generasi" class="form-select">
                        <option value="" disabled selected>Pilih Generasi</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="alumni">Alumni</option>
                    </select>
                </div>

                <!-- Program Studi -->
                <div class="mb-4" id="field-prodi">
                    <label class="form-label required">Program Studi</label>
                    <select name="program_studi" id="program_studi" class="form-select">
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
                            <option>Hubungan Masyarakat dan Komunikasi Digital</option>
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
                    <input type="text" name="instansi" id="instansi" class="form-control"
                        value="{{ old('instansi') }}">
                </div>

                <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </form>

        </div>
    </div>
</body>
<script>
    const tipePeserta = document.getElementById('tipe_peserta');
    const fieldGenerasi = document.getElementById('field-generasi');
    const fieldProdi = document.getElementById('field-prodi');

    const generasiInput = document.getElementById('generasi');
    const prodiInput = document.getElementById('program_studi');
    const instansiInput = document.getElementById('instansi');

    // Default hidden
    fieldGenerasi.style.display = 'none';
    fieldProdi.style.display = 'none';

    tipePeserta.addEventListener('change', function () {
        if (this.value === 'mahasiswa_pcr') {
            // Tampilkan field mahasiswa
            fieldGenerasi.style.display = 'block';
            fieldProdi.style.display = 'block';

            generasiInput.required = true;
            prodiInput.required = true;

            // AUTO SET INSTANSI
            instansiInput.value = 'Politeknik Caltex Riau';
            instansiInput.readOnly = true;

        } else {
            // Sembunyikan field mahasiswa
            fieldGenerasi.style.display = 'none';
            fieldProdi.style.display = 'none';

            generasiInput.required = false;
            prodiInput.required = false;

            generasiInput.value = '';
            prodiInput.value = '';

            // BUKA INSTANSI UNTUK TAMU
            instansiInput.value = '';
            instansiInput.readOnly = false;
        }
    });
</script>


</html>
