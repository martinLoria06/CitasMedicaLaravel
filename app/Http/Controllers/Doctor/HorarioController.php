<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Horarios;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function edit() {
        $days = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
        return view('horario',compact('days'));
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
