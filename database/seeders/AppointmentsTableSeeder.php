<?php

namespace Database\Seeders;

use App\Models\Appoinment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appoinment::factory()
            ->count(300)
            ->create();
    }
}
