<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('password'),
        //     'email_verified_at' => now(),
        // ]);

        // User::factory()->create([
        //     'name' => 'GFI',
        //     'email' => 'gfi@emater.tche.br',
        //     'password' => Hash::make('@dminGFI'),
        //     'email_verified_at' => now(),
        // ]);

        User::factory()->create([
            'name' => 'Felipe Scholl',
            'email' => 'fscholl@emater.tche.br',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
} 