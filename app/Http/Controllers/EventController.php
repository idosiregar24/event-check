<?php

namespace App\Http\Controllers;
use App\Models\Event;

class EventController extends Controller{
public function guestSeats($id)
{
    $event = Event::findOrFail($id);
    $guests = $event->guests()->orderBy('id')->get(); // pastikan urut agar posisi kursi konsisten

    return view('admin.partials.guest_seats', compact('guests', 'event'));
}

}

