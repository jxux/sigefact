<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceBinnacleRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $id = $this->input('id');
        return [
            'code' => [
                'required',
                'max:5'
            ],
            'name' => [
                'required',
            ],
            'category_id' =>[
                'required',
            ],
        ];
    }
}