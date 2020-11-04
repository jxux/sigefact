<?php

namespace App\CoreFacturalo\Requests\Inputs\Common;
use App\Models\Tenant\Category as CategoryModel;

class CategoryInput{
    public static function set($category_id){
        $category = CategoryModel::find($category_id);

        return [
            'code' => $category->code,
            'name' => $category->name,

        ];
    }
}