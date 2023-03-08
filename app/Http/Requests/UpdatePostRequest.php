<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', Rule::unique('projects')->ignore($this->project) ,'max:250'],
            'description' => ['nullable', 'max:400'],
            'type_id' => ['nullable','exists:types,id'],
            'technologies' =>['exists:technologies,id'],
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
    */
    public function messages()
    {
        return [
            'title.required' => 'Il titolo è obbligatorio',
            'title.unique' => 'Questo titolo è già stato assegnato ad un progetto',
            'title.max' => 'Il titolo non deve essere più lungo di :max caratteri',
            'description.max' => 'La descrizione non può contenere più di :max caratteri',
            'type_id.exists' => 'Seleziona tipo',
            'technologies.exists' => 'Tecnologia non valida'
        ];
    }
}
