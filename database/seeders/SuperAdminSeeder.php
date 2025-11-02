<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Ido Super Admin',
            'email' => 'ido24si@mahasiswa.pcr.ac.id',
            'password' => Hash::make('Asdfg123'),
            'role' => 'super_admin',
        ]);
    }
}
