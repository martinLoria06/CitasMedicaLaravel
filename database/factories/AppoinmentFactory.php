<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appoinment>
 */
class AppoinmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-1 years','now');
        $scheduled_date = $date->format('Y-m-d');
        $schedule_time = $date->format('H:i:s');
        $types = ['Consultas','Examen','Operacion'];
        $doctorsIds = User::doctors()->pluck('id');
        $patientIds = User::patients()->pluck('id');
        $tatuses = ['Atendida','Cancelada'];

        return [
            'scheduled_date'=> $scheduled_date,
            'schedule_time'=>$schedule_time,
            'type'=>$this->faker->randomElement($types),
            'description'=>$this->faker->sentence(5),
            'doctor_id'=>$this->faker->randomElement($doctorsIds),
            'patient_id'=>$this->faker->randomElement($patientIds),
            'specialty_id'=>$this->faker->numberBetween(1,7),
            'status'=>$this->faker->randomElement($tatuses)
        ];
    }
}
