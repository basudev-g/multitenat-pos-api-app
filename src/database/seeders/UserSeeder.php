<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // OWNER
        User::create([
            'name'      => 'Demo Owner',
            'email'     => 'owner@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'owner',
            'tenant_id' => 1,
        ]);

        // STAFF
        User::create([
            'name'      => 'Demo Staff',
            'email'     => 'staff@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'staff',
            'tenant_id' => 1,
        ]);
    }
}
