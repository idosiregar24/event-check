<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_event',
        'tanggal',
        'lokasi',
        'deskripsi',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'id');
    }


    // Relasi many-to-many ke User (admin)
    public function admins()
    {
        return $this->belongsToMany(User::class, 'event_admins');
    }

    // Relasi one-to-many ke guest
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
}
