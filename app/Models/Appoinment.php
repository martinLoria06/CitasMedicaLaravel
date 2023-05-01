<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function specialty(){
        return $this->belongsTo(Specialty::class);
    }

    public function doctor(){
        return $this->belongsTo(User::class);
    }

    public function patient(){
        return $this->belongsTo(User::class);
    }

    public function cancellation(){
        return $this->hasOne(CancelAppintment::class);
    }

    public function getScheduleTime12Attribute(){
        return(new Carbon($this->schedule_time))->format('g:i A');
    }

}
