<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'syahdan mutahariq',
            'email' => 'adansyah225@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'kelurahan',
            'email' => 'keluarahan@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'kelurahan'
        ]);
    }
}
