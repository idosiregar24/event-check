<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Event;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                \Illuminate\Validation\Rule::unique('guests')->where(function ($query) use ($event) {
                    return $query->where('event_id', $event->id);
                })
            ],
            'instansi' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Token untuk QR unik
        $token = \Str::uuid()->toString();

        // 🔹 Generate kode undian angka acak (misal 8 digit)
        $kodeUndian = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

        // 🔹 Simpan ke database
        $guest = Guest::create([
            'name' => $request->name,
            'email' => $request->email,
            'instansi' => $request->instansi,
            'phone' => $request->phone,
            'qr_token' => $token,
            'kode_undian' => $kodeUndian,
            'event_id' => $event->id,
        ]);

        // 🔹 Generate QR Code (bisa isi link atau kode undian)
        $link = url('/check?' . $guest->qr_token);
        $qrCode = QrCode::size(200)->generate($link);

        // 🔹 Tampilkan halaman sukses
        return view('guest.success', compact('guest', 'qrCode', 'event'));
    }

    // Tampilkan form absensi / cek kode undian
    public function checkForm()
    {
        redirect()->route('guest.check');
    }

    // Method untuk memproses pengecekan & absensi
    public function check(Request $request)
    {
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

}



