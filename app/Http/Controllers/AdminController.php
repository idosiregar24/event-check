<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class AdminController extends Controller
{
    public function guests(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        $query = $event->guests(); // pastikan relasi 'guests' ada di model Event

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('instansi', 'like', "%$search%");
            });
        }

        $guests = $query->latest()->get();

        if ($request->ajax()) {
            return view('admin.partials.guest_table', compact('guests'))->render();
        }

        return view('admin.guests.index', compact('event', 'guests'));
    }


    public function dashboard()
    {
        $admin = auth()->user();

        $events = $admin->events()->latest()->get();

        return view('admin.dashboard', compact('events'));
    }



}
