<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Horarios;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function edit() {
        $days = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

        $horarios = Horarios::where('user_id',auth()->id())->get();
        $horarios->map(function($horarios){
            $horarios->morning_start = (new Carbon($horarios->morning_start))->format('g:i A');
            $horarios->morning_end = (new Carbon($horarios->morning_end))->format('g:i A');
            $horarios->afternoon_start = (new Carbon($horarios->afternoon_start))->format('g:i A');
            $horarios->afternoon_end = (new Carbon($horarios->afternoon_end))->format('g:i A');
        });
        //  dd($horarios->toArray());

        return view('horario',compact('days','horarios'));
    }

    public function store(Request $request) {
        $active = $request->active ?: [] ;
        $morning_start = $request->morning_start;
        $morning_end = $request->morning_end;
        $afternoon_start = $request->afternoon_start;
        $afternoon_end = $request->afternoon_end;

// dd($afternoon_end);

        for ($i=0; $i <7; $i++) {
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

        return back();

    }
}
