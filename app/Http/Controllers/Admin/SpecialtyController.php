<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\specialtyRequest;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{

    public function index()
    {
        $specialties = Specialty::all();

        return view('specialties.index',compact('specialties'));
    }

    public function create() {
        return view('specialties.create');
    }

    public function sendData(specialtyRequest $request) {
        $specialty = new Specialty();
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save();

        return redirect()->route('especialidades.index')->with('success','La especilidad se ha creado correctamente');
    }

    public function edit(Specialty $specialty){
        return view('specialties.edit',compact('specialty'));
    }

    public function update(specialtyRequest $request, Specialty $specialty) {
        $specialty = new Specialty();
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save();

        return redirect()->route('especialidades.index')->with('success', 'La especilidad se ha actulizado correctamente');
    }

    public function destroy(Specialty $specialty){
        $specialty->delete();
        return redirect()->route('especialidades.index')->with('success','La especilidad '.  $specialty->name .' se ha eliminado correctamente');
    }
}
