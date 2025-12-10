<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class CheckinController extends Controller
{

    public function showForm(Request $request)
    {
        // Pastikan param tamu dikirim
        if (!$request->has('tamu')) {
            return "QR tidak valid. Parameter tamu tidak ditemukan.";
        }

        $guest = Guest::find($request->tamu);

        if (!$guest) {
            return "QR tidak valid. Tamu tidak ditemukan.";
        }

        return view('admin.checkin-form', compact('guest'));
    }


    public function submit(Request $request)
    {
        $request->validate([
            'guest_id' => 'required',
            'nim' => 'required'
        ]);

        $guest = Guest::find($request->guest_id);

        if (!$guest) {
            return "Data tamu tidak ditemukan.";
        }

        // Validasi NIM
        if ($guest->nim != $request->nim) {
            return back()->with('error', 'NIM tidak cocok. Silakan coba lagi.');
        }

        // Ubah status hadir
        $guest->status_kehadiran = 'Hadir';
        $guest->save();

        return view('checkin-success', compact('guest'));
    }

    public function cariNim(Request $request)
    {
        $guest = Guest::where('phone', $request->nim)->first();

        if (!$guest) {
            return response()->json(['status' => false]);
        }

        return response()->json([
            'status' => true,
            'nama' => $guest->name,
            'prodi' => $guest->program_studi,
            'nim' => $guest->phone
        ]);
    }






    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
