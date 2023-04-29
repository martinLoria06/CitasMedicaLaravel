<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppoimentRequest;
use App\Interfaces\HorarioServiceInterface;
use App\Models\Appoinment;
use App\Models\Specialty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{

    public function index(){
        $appointments = Appoinment::all();
        return view('appoinments.index',compact('appointments'));
    }

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
            $intervals = $horarioServiceInterface->getAvailableIntervals($date, $doctorId);
        } else {
            $intervals = null;
        }


        return view('appoinments.create', compact('specialties', 'doctors', 'intervals'));
    }

    public function store(Request $request, HorarioServiceInterface $horarioServiceInterface)
    {

        $rules = [
            'schedule_time' => 'required',
            'type' => 'required',
            'description' => 'required',
            'doctor_id' => 'exists:users,id',
            'specialty_id' => 'exists:specialties,id'
        ];

        $messages = [
            'schedule_time.required' => "Debe seleccionar una hora válida para su cita",
            'type.required' => "Debe seleccionar el typo de consulta x",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use($request, $horarioServiceInterface){
            $date = $request->input('scheduled_date');
            $doctorId = $request->input('doctor_id');
            $schedule_time = $request->input('schedule_time');

            if($date && $doctorId && $schedule_time){
                $start = new Carbon($schedule_time);
            } else {
                return ;
            }

            if (!$horarioServiceInterface->isAvaliableIntervals($date,$doctorId,$start)) {
                $validator->errors()->add(
                    'available_time', 'La Hora ya esta selecionada por otro paciente'
                );
            }
        });

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

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
