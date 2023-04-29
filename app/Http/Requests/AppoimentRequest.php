<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppoimentRequest extends FormRequest
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
            'schedule_time'=>'required',
            'type'=>'required',
            'description'=>'required',
            'doctor_id'=>'exists:users,id',
            'specialty_id'=>'exists:specialties,id'
        ];
    }

    public function messages()
    {
        return[
            'schedule_time.required' =>"Debe seleccionar una hora válida para su cita",
            'type.required' => "Debe seleccionar el typo de consulta",
        ];
    }
}
