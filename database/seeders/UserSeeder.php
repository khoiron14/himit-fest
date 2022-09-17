<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@himit.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin
        ]);
        User::create([
            'username' => 'peserta',
            'email' => 'peserta@himit.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Participant
        ]);
    }
}
