<?php

namespace App\Http\Controllers\tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Category;
use App\Http\Resources\Tenant\CategoryCollection;
use App\Http\Resources\Tenant\CategoryResource;
use App\Http\Requests\Tenant\CategoryRequest;
use Exception;

class BinnacleCategorysController extends Controller{

    public function records(){
        $records = Category::all();
        return new CategoryCollection($records);
    }

    public function record($id){
        $record = new CategoryResource(Category::findOrFail($id));
        return $record;
    }

    public function store(CategoryRequest $request){
        $id = $request->input('id');
        $category = Category::firstOrNew(['id' => $id]);
        $category->fill($request->all());
        $category->save();

        return [
            'success' => true,
            'message' => ($id)?'Categoría editado con éxito':'Categoría registrado con éxito'
        ];
    }

    public function destroy($id){
        try {            
            
            $bank = Category::findOrFail($id);
            $bank->delete(); 

            return [
                'success' => true,
                'message' => 'Categoría eliminada con éxito'
            ];

        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false,'message' => 'La categoria esta siendo usado por otros registros, no puede eliminar'] : ['success' => false,'message' => 'Error inesperado, no se pudo eliminar la categoria'];

        }
    }
    
}