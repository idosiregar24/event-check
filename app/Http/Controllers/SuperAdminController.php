<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    // Halaman dashboard utama super admin
    public function dashboard()
    {
        $totalEvents = Event::count();
        $recentEvents = Event::latest()->take(5)->get();

        return view('superadmin.dashboard', compact('totalEvents', 'recentEvents'));
    }

    // Daftar semua event
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('superadmin.events.index', compact('events'));
    }

    // Form tambah event
    public function create()
    {
        return view('superadmin.events.create');
    }

    // Simpan event baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Event::create([
            'nama_event' => $request->nama_event,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('superadmin.events.index')->with('success', 'Event berhasil dibuat.');
    }

    // Form edit
    public function edit(Event $event)
    {
        return view('superadmin.events.edit', compact('event'));
    }

    // Update event
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'nama_event' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload file baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($event->gambar && file_exists(public_path('uploads/event/' . $event->gambar))) {
                unlink(public_path('uploads/event/' . $event->gambar));
            }

            $file = $request->file('gambar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/event'), $fileName);
            $event->gambar = $fileName;
        }

        // Update data lain
        $event->update([
            'nama_event' => $request->nama_event,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'gambar' => $event->gambar ?? null,
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'Event berhasil diperbarui.');
    }

    public function assignAdminForm($id)
    {
        $event = Event::findOrFail($id);
        $admins = User::where('role', 'admin')->get();

        return view('superadmin.assignAdmin.create', compact('event', 'admins'));
    }

    public function assignAdminStore(Request $request, $eventId)
    {
        $request->validate([
            'admin_id' => 'nullable|exists:users,id',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|string|min:6',
        ]);

        $event = Event::findOrFail($eventId);

        // Jika pilih admin lama
        if ($request->filled('admin_id')) {
            $event->admins()->syncWithoutDetaching($request->admin_id);
        }

        // Jika buat admin baru
        if ($request->filled(['name', 'email', 'password'])) {
            $admin = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin',
            ]);

            $event->admins()->attach($admin->id);
        }

        return redirect()->route('superadmin.events.index')->with('success', 'Admin berhasil ditambahkan ke event!');
    }


    // Hapus event
    public function destroy(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Event berhasil dihapus.');
    }
}
