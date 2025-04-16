<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('12345678'),

        ]);

        User::create([
            'name' => 'Staff User',
            'email' => 'staff@gmail.com',
            'role' => 'staff',
            'password' => Hash::make('12345678'),

        ]);
    }
}
