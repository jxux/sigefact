<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
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
        ];
    }
}