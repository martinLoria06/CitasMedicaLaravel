<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class hoursRequest extends FormRequest
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
            'date'=>'required|date_format:"Y-m-d"',
            'doctor_id'=>'required|exists:users,id'
        ];
    }
}
