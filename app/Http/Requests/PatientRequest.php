<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|min:3',
            'email' => 'required|email',
            'cedula'=> 'required|digits:10',
            'address' => 'nullable|min:6',
            'phone' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del paciente es requerido',
            'name.min' => 'El nombre del paciente debe tener mas de 3 caracteres',
            'email.required' => 'El correo electronico es obligatorio',
            'email.email' => 'Ingresa una direccion de correo electronico valido',
            'cedula.required' => 'La cedula es obligatoria',
            'cedula.digits' => 'La cedula debe de tener al menos 10 caracteres',
            'address.min' => 'La direccion debe tener al menos 6 caracteres',
            'phone.required' => 'El numero de telefono es obligatorio'
        ];
    }
}
