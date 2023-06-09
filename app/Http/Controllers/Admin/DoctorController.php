<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Specialty;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = User::doctors()->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specialties = Specialty::all();
        return view('doctors.create',compact('specialties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name'  => 'required|min:3',
            'email' => 'required|email',
            'cedula'=> 'required|digits:10',
            'address' => 'nullable|min:6',
            'phone' => 'required'

        ];

        $messages = [
            'name.required' => 'El nombre del médico es requerido',
            'name.min' => 'El nombre del médico debe tener mas de 3 caracteres',
            'email.required' => 'El correo electronico es obligatorio',
            'email.email' => 'Ingresa una direccion de correo electronico valido',
            'cedula.required' => 'La cedula es obligatoria',
            'cedula.digits' => 'La cedula debe de tener al menos 10 caracteres',
            'address.min' => 'La direccion debe tener al menos 6 caracteres',
            'phone.required' => 'El numero de telefono es obligatorio'
        ];

        $this->validate($request, $rules, $messages);

        $user = User::create(
            $request->only('name','email','cedula','address','phone')
            + [
                'role'=>'Doctor',
                'password' => bcrypt($request->password)
            ]
        );

        $user->specialty()->attach($request->specialties);
        // $user->specialty()->attach($request->input('specialties'));

        $success = 'El médico se ha registrado correctamente';

        return redirect()->route('medicos.index')->with(compact('success'));
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
        $doctor = User::doctors()->findOrFail($id);
        $specialties = Specialty::all();
        $specialty_ids = $doctor->specialties()->pluck('specialties.id');
        return view('doctors.edit',compact('doctor','specialties','specialty_ids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name'  => 'required|min:3',
            'email' => 'required|email',
            'cedula'=> 'required|digits:10',
            'address' => 'nullable|min:6',
            'phone' => 'required'

        ];

        $messages = [
            'name.required' => 'El nombre es requedo',
            'name.min' => 'El nombre del médico debe tener mas de 3 caracteres',
            'email.required' => 'El correo electronico es obligatorio',
            'email.email' => 'Ingresa una direccion de correo electronico valido',
            'cedula.required' => 'La cedula es obligatoria',
            'cedula.digits' => 'La cedula debe de tener al menis 10 caracteres',
            'address.min' => 'La direccion debe tener al menos 6 caracteres',
            'phone.required' => 'El numero de telefono es obligatorio'
        ];

        $this->validate($request, $rules, $messages);
        $doctor = User::doctors()->findOrFail($id);
        $data = $request->only('name','email','cedula','address','phone');
        $password = $request->password;

        if($password) {
            $data['password'] = bcrypt($password);
        }

        $doctor ->fill($data);
        $doctor->save();
        $doctor->specialties()->sync($request->specialties);


        $success = 'La informacion del médico se ha actulizado correctamente';

        return redirect()->route('medicos.index')->with(compact('success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor  = User::doctors()->findOrFail($id);
        $doctorName = $doctor->name;
        $doctor->delete();

        $success = "El medico $doctorName se elimino correctamente";

        return redirect()->route('medicos.index')->with(compact('success'));
    }
}
