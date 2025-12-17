<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class GuestController extends Controller
{
    // Menampilkan form registrasi
    public function showForm($eventId)
    {
        $event = Event::findOrFail($eventId);
        return view('guest.register', compact('event'));
    }


    // Menyimpan data tamu & generate QR Code
    public function store(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        // VALIDASI INPUT
        $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                \Illuminate\Validation\Rule::unique('guests')->where(function ($query) use ($event) {
                    return $query->where('event_id', $event->id);
                })
            ],

            'asal_tamu' => 'required|in:tamu,mahasiswa_pcr',

            'generasi' => 'nullable|in:22,23,24,25,alumni',

            'program_studi' => [
                'nullable',
                \Illuminate\Validation\Rule::in([
                    // Jurusan TI
                    'Teknik Informatika',
                    'Sistem Informasi',
                    'Teknologi Rekayasa Komputer',
                    'Magister Terapan Teknik Komputer',

                    // Jurusan Bisnis & Komunikasi
                    'Akuntansi Perpajakan',
                    'Hubungan Masyarakat dan Komunikasi Digital',
                    'Bisnis Digital',

                    // Jurusan Teknik
                    'Teknik Mesin',
                    'Teknik Listrik',
                    'Teknologi Rekayasa Mekatronika',
                    'Teknik Elektronika',
                    'Teknologi Rekayasa Sistem Elektronika',
                    'Teknologi Rekayasa Jaringan Telekomunikasi',
                ])
            ],
            'instansi' => 'nullable|string|max:255',
        ], [
            'email.unique' => 'Email ini sudah terdaftar untuk event ini, silahkan gunakan email lain dan beritahukan kepada panitia.'
        ]);


        // GENERATE TOKEN QR
        $token = \Str::uuid()->toString();

        if ($request->asal_tamu === 'tamu') {
            $data['generasi'] = null;
            $data['program_studi'] = null;
        }

        // SIMPAN KE DATABASE
        $guest = Guest::create([
            'name' => $request->name,
            'email' => $request->email,
            'instansi' => $request->instansi,
            'generasi' => $request->generasi,
            'status' => 'Hadir',
            'asal_tamu' => $request->asal_tamu,
            'program_studi' => $request->program_studi,
            'qr_token' => $token,
            'event_id' => $event->id,
        ]);


        // GENERATE QR CODE
        $link = url('/check?' . $guest->qr_token);
        $qrCode = QrCode::size(200)->generate($link);


        // RETURN SUCCESS PAGE
        return view('guest.success', compact('guest', 'qrCode', 'event'));
    }


    public function checkForm()
    {
        redirect()->route('guest.check');
    }

    public function generateQr($guest_id)
    {
        $guest = Guest::findOrFail($guest_id);

        $url = route('checkin.form', ['tamu' => $guest->id]);

        $qrCode = QrCode::size(250)->generate($url);

        return view('admin.event-qr', compact('guest', 'qrCode'));
    }


    public function check(Request $request)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect('/login')->with('error', '❌ Anda harus login terlebih dahulu.');
        }

        $user = Auth::user();

        // Pastikan hanya admin yang bisa scan
        if ($user->role !== 'admin') {
            return view('guest.result', [
                'status' => 'error',
                'message' => '❌ Anda tidak memiliki izin untuk melakukan scan absensi.',
            ]);
        }

        // Ambil token UUID dari query string
        $query = $request->query();
        $token = array_key_first($query); // misal: check?68e79... → token = 68e79...

        // Cek apakah token ada
        if (!$token) {
            return view('guest.result', [
                'status' => 'error',
                'message' => '❌ Token tidak ditemukan dalam URL.',
            ]);
        }

        // Cari tamu berdasarkan qr_token
        $guest = Guest::where('qr_token', $token)->first();

        // Kalau token tidak cocok
        if (!$guest) {
            return view('guest.result', [
                'status' => 'error',
                'message' => '❌ Data tamu tidak ditemukan.',
            ]);
        }

        // Kalau sudah hadir sebelumnya
        if ($guest->status === 'Hadir') {
            return view('guest.result', [
                'status' => 'warning',
                'message' => '⚠️ ' . $guest->name . ' sudah tercatat hadir sebelumnya.',
                'guest' => $guest,
            ]);
        }

        // Update status menjadi Hadir
        $guest->update(['status' => 'Hadir']);

        // Tampilkan pesan sukses
        return view('guest.check', [
            'status' => 'success',
            'message' => '✅ Selamat datang, ' . $guest->name . '! Kehadiran Anda telah dicatat.',
            'guest' => $guest,
        ]);
    }




    public function exportPdf($id)
    {
        $event = Event::findOrFail($id);
        $guests = Guest::where('event_id', $id)->get();

        $pdf = Pdf::loadView('admin.partials.guest_pdf', compact('event', 'guests'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Daftar_Tamu_' . $event->nama_event . '.pdf');
    }


}



