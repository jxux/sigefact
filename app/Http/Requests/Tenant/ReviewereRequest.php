<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ReviewereRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            // $id = $this->input('id');

        ];
    }

    // public function messages(){
    //     return [
    //         'category_id.required' => 'El campo categoría es obligatorio.',
    //         'description.min' => 'La descripción debe ser mayor a 20 caracteres.',
    //         'start_time.required' => 'El campo Hora de Inicio es obligatorio.',
    //         'end_time.required' => 'El campo Hora de Fin es obligatorio.',
    //         'client_id.required' => 'El campo cliente es obligatorio.',
    //         'period.required' => 'El campo periodo es obligatorio.',
    //     ];
    // }
}
