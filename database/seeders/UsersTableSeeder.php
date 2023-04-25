<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            User::create([
                'name' => 'Martin Loria',
                'email' => 'martinloria74@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345678'), // password
                'cedula' => '0400000712',
                'address' => 'Av. Juan Pablo',
                'phone' => '999999999',
                'role' => 'admin',
            ]);

            User::factory()
            ->count(50)
            ->create();
    }
}
