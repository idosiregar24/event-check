<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

    // Form edit event
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
            if ($event->gambar && file_exists(public_path('uploads/event/' . $event->gambar))) {
                unlink(public_path('uploads/event/' . $event->gambar));
            }

            $file = $request->file('gambar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/event'), $fileName);
            $event->gambar = $fileName;
        }

        $event->update([
            'nama_event' => $request->nama_event,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'gambar' => $event->gambar ?? null,
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'Event berhasil diperbarui.');
    }


    // ===============================
    //      QR CODE SECTION
    // ===============================

    // Halaman menampilkan QR
    public function generateQR($id)
    {
        $url = url('/register/' . $id);

        // Generate SVG string (aman tanpa imagick)
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(300)
            ->errorCorrection('H')
            ->generate($url);

        return view('superadmin.showQR', compact('qrCode', 'url', 'id'));
    }


    // Download PNG
    public function downloadQR($id)
    {
        $url = url('/register/' . $id);

        $qr = QrCode::format('svg')
            ->size(500)
            ->errorCorrection('H')
            ->generate($url);

        return response($qr)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="QR_Event_' . $id . '.svg"');
    }



    // ===============================
    //     ADMIN EVENT SECTION
    // ===============================

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

        if ($request->filled('admin_id')) {
            $event->admins()->syncWithoutDetaching($request->admin_id);
        }

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

    public function destroy(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Event berhasil dihapus.');
    }
}
