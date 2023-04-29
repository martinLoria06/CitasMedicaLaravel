<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appoinment extends Model
{
    use HasFactory;
    protected $fillable = [
            'scheduled_date',
            'schedule_time',
            'type',
            'description',
            'doctor_id',
            'patient_id',
            'specialty_id'
    ];
}
