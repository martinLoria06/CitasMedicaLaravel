<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = User::patients()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        User::create(
            $request->only('name','email','cedula','address','phone')
            + [
                'role'=>'Paciente',
                'password' => bcrypt($request->password)
            ]
        );

        return redirect()->route('pacientes.index')->with('success','El paciente se ha creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patient = User::patients()->findOrFail($id);
        return view('patients.edit',compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, string $id)
    {
        $patient = User::patients()->findOrFail($id);
        $data = $request->only('name','email','cedula','address','phone');
        $password = $request->password;

        if($password) {
            $data['password'] = bcrypt($password);
        }

        $patient ->fill($data);
        $patient->save();

        return redirect()->route('pacientes.index')->with('success','La informacion del paciente se ha actulizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient  = User::patients()->findOrFail($id);
        $patientName = $patient->name;
        $patient->delete();

        return redirect()->route('pacientes.index')->with('success',"El paciente $patientName se elimino correctamente");
    }
}
