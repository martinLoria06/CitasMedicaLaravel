<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppoimentRequest;
use App\Interfaces\HorarioServiceInterface;
use App\Models\Appoinment;
use App\Models\CancelAppintment;
use App\Models\Specialty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{

    public function index()
    {

        $role = auth()->user()->role;
        if ($role == 'admin') {
            // Admin
            $confirmedAppoinments = Appoinment::all()->where('status', 'Confirmada');
            $pendingAppointments = Appoinment::all()->where('status', 'Reservada');
            $oldAppointments = Appoinment::all()->whereIn('status', ['Atendida', 'Cancelada']);
        } elseif ($role == 'Doctor') {
            // Doctor
            $confirmedAppoinments = Appoinment::all()->where('status', 'Confirmada')
                ->where('doctor_id', auth()->id());
            $pendingAppointments = Appoinment::all()->where('status', 'Reservada')
                ->where('doctor_id', auth()->id());
            $oldAppointments = Appoinment::all()->whereIn('status', ['Atendida', 'Cancelada'])
                ->where('doctor_id', auth()->id());
        } elseif ($role == 'Paciente') {
            // Pacientes
            $confirmedAppoinments = Appoinment::all()->where('status', 'Confirmada')
                ->where('patient_id', auth()->id());
            $pendingAppointments = Appoinment::all()->where('status', 'Reservada')
                ->where('patient_id', auth()->id());
            $oldAppointments = Appoinment::all()->whereIn('status', ['Atendida', 'Cancelada'])
                ->where('patient_id', auth()->id());
        }

        return view('appoinments.index', compact('confirmedAppoinments', 'pendingAppointments', 'oldAppointments', 'role'));
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

        $validator->after(function ($validator) use ($request, $horarioServiceInterface) {
            $date = $request->input('scheduled_date');
            $doctorId = $request->input('doctor_id');
            $schedule_time = $request->input('schedule_time');

            if ($date && $doctorId && $schedule_time) {
                $start = new Carbon($schedule_time);
            } else {
                return;
            }

            if (!$horarioServiceInterface->isAvaliableIntervals($date, $doctorId, $start)) {
                $validator->errors()->add(
                    'available_time',
                    'La Hora ya esta selecionada por otro paciente'
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

    public function cancelar(Appoinment $appointment, Request $request)
    {
        if ($request->has('justificacion')) {
            $cancelation = new CancelAppintment();
            $cancelation->justificacion = $request->justificacion;
            $cancelation->cancelled_by_id = auth()->id();

            $appointment->cancellation()->save($cancelation);
        }
        $appointment->status = "Cancelada";
        $appointment->save();
        return redirect()->route('miscitas.index')->with('success', 'La cita fue cancelada correcatmente');
    }

    public function formCancel(Appoinment $appointment)
    {
        if ($appointment->status == 'Confirmada') {
            $role = auth()->user()->role;
            return view('appoinments.cancel', compact('appointment','role'));
        }

        return redirect()->route('miscitas.index');
    }

    public function show(Appoinment $appointment)
    {
        $role = auth()->user()->role;
        return view('appoinments.show', compact('appointment', 'role'));
    }

    public function confirm(Appoinment $appointment)
    {

        $appointment->status = "Confirmada";
        $appointment->save();
        return redirect()->route('miscitas.index')->with('success', 'La cita fue confirmada correcatmente');
    }
}
