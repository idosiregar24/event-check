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

        $token = \Str::uuid()->toString();

        $guest = Guest::create([
            'name' => $request->name,
            'email' => $request->email,
            'instansi' => $request->instansi,
            'phone' => $request->phone,
            'qr_token' => $token,
            'event_id' => $event->id,
        ]);

        $link = route('guest.check', $guest->qr_token);
        $qrCode = QrCode::size(200)->generate($link);

        return view('guest.success', compact('guest', 'qrCode', 'event'));
    }


}
