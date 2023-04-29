<?php

namespace Database\Seeders;

use App\Models\Specialty;
use App\Models\User;
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

        foreach($specialties as $specialtyName){
           $specialty = Specialty::create([
                            'name'=>$specialtyName
                        ]);
           $specialty->users()->saveMany(
                User::factory(4)->state(['role'=>'Doctor'])->make()
           );
        }
        User::find(3)->specialties()->save($specialty);
    }
}
