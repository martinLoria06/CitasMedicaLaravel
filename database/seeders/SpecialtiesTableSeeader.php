<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtiesTableSeeader extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            'Neurología',
            'Quirúrgica',
            'Pediatría',
            'Cardilogía',
            'Urología',
            'Medicina Forence',
            'Dermatologia'
        ];

        foreach($specialties as $specialty){
            Specialty::create([
                'name'=>$specialty
            ]);
        }
    }
}
