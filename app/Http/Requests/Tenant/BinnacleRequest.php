<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class BinnacleRequest extends FormRequest{
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
            'date' => [
                'required',
            ],
            'start_time' => [
                'required',
            ],
            'end_time' => [
                'required',
            ],
            'hour' => [
                // 'required',
            ],
            'client_id' => [
                'required',
            ],
            'category_id' => [
                'required',
            ],
            'service_id' => [
                'required'
            ],
            'period' => [
                'required',
            ],
            'description' => [
                'required',
                'min:15'
            ],
            'status' => [
                'required',
                'numeric',
                // 'min:'
            ],
        ];
    }

    public function messages(){
        return [
            'category_id.required' => 'El campo categoría es obligatorio.',
            'description.min' => 'La descripción debe ser mayor a 20 caracteres.',
            'start_time.required' => 'El campo Hora de Inicio es obligatorio.',
            'end_time.required' => 'El campo Hora de Fin es obligatorio.',
            'client_id.required' => 'El campo cliente es obligatorio.',
            'period.required' => 'El campo periodo es obligatorio.',
        ];
    }
}
