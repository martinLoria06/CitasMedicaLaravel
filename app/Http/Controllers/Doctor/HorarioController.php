<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Horarios;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    private $days = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
    public function edit() {

        $horarios = Horarios::where('user_id',auth()->id())->get();

        if(count($horarios) > 0){
            $horarios->map(function($horarios){
                $horarios->morning_start = (new Carbon($horarios->morning_start))->format('g:i A');
                $horarios->morning_end = (new Carbon($horarios->morning_end))->format('g:i A');
                $horarios->afternoon_start = (new Carbon($horarios->afternoon_start))->format('g:i A');
                $horarios->afternoon_end = (new Carbon($horarios->afternoon_end))->format('g:i A');
            });
        } else {
            $horarios = collect();
            for ($i=0; $i <7 ; $i++) {
                $horarios->push(new Horarios());
            }
        }

        //  dd($horarios->toArray());
        $days = $this->days;

        return view('horario',compact('days','horarios'));
    }

    public function store(Request $request) {
        // dd($request->all());
        $active = $request->active ?: [] ;
        $morning_start = $request->morning_start;
        $morning_end = $request->morning_end;
        $afternoon_start = $request->afternoon_start;
        $afternoon_end = $request->afternoon_end;

// dd($afternoon_end);

        $errors = [];

        for ($i=0; $i <7; $i++) {
            if($morning_start[$i] > $morning_end[$i]){
                $errors[] = "Inconsistencias en el intervalo de las horas del turno de la mañana del dia " .$this->days[$i]. '.';
            }
            if($afternoon_start[$i] > $afternoon_end[$i]){
                $errors[] = "Inconsistencias en el intervalo de las horas del turno de la tarde del dia " .$this->days[$i]. '.';
            }
            Horarios::updateOrCreate(

                [
                    'day' => $i,
                    'user_id' => auth()->id()
                ],
                [
                    'active' => in_array($i, $active),
                    'morning_start'=>$morning_start[$i],
                    'morning_end'=>$morning_end[$i],
                    'afternoon_start'=>$afternoon_start[$i],
                    'afternoon_end'=>$afternoon_end[$i],

                ]

            );

        }
        if(count($errors) > 0){
            return back()->with(compact('errors'));
        }
        return back()->with('success','Los cambios se han guardado correctamente');

    }
}
