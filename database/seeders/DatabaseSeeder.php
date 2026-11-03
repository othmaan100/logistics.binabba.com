<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Local accounts: role 1 = admin dashboard, role 2 = staff dashboard
        User::updateOrCreate(['email' => 'admin@binabba.com'], [
            'fullName' => 'Admin',
            'phone' => '08000000001',
            'address' => 'Head Office',
            'role' => '1',
            'status' => '1',
            'password' => Hash::make('123456'),
        ]);

        User::updateOrCreate(['email' => 'secretary@binabba.com'], [
            'fullName' => 'Secretary',
            'phone' => '08000000002',
            'address' => 'Head Office',
            'role' => '2',
            'status' => '1',
            'password' => Hash::make('123456'),
        ]);
    }
}
