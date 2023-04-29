<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppoimentRequest;
use App\Interfaces\HorarioServiceInterface;
use App\Models\Appoinment;
use App\Models\Specialty;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create(HorarioServiceInterface $horarioServiceInterface)
    {
        $specialties = Specialty::all();
        $specialtyId = old('specialty_id');
        if ($specialtyId) {
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
        } else {
            $doctors = collect();
        }

        $date = old('scheduled_date');
        $doctorId = old('doctor_id');
        if ($date && $doctorId) {
            $intervals = $horarioServiceInterface->getAvailableIntervals($date,$doctorId);
        } else {
            $intervals = null;
        }


        return view('appoinments.create', compact('specialties','doctors','intervals'));
    }

    public function store(AppoimentRequest $request)
    {
        $data = $request->only([
            'scheduled_date',
            'schedule_time',
            'type',
            'description',
            'doctor_id',
            'specialty_id'
        ]);

        $data['patient_id'] = auth()->id();
        $carbonTime = Carbon::createFromFormat('g:i A', $data['schedule_time']);
        $data['schedule_time'] = $carbonTime->format('H:i:s');

        Appoinment::create($data);

        return back()->with('success', 'La cita se ha realizado correctamente');
    }
}
