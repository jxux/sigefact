<?php

namespace App\Http\Controllers\tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Service;
use App\Models\Tenant\Category;
use App\Http\Resources\Tenant\ServiceCollection;
use App\Http\Resources\Tenant\ServiceResource;
use App\Http\Requests\Tenant\ServiceBinnacleRequest;
use Exception;

class BinnacleServicesController extends Controller{

    public function records(){

        $records = Service::all();
        return new ServiceCollection($records);

    }

    public function record($id){
        $record = new ServiceResource(Service::findOrFail($id));

        return $record;
    }


    public function tables(){
        $category = Category::get();
        return compact('category');
    }

    public function store(ServiceBinnacleRequest $request){
        $id = $request->input('id');
        $service = Service::firstOrNew(['id' => $id]);
        $service->fill($request->all());
        $service->save();

        return [
            'success' => true,
            'message' => ($id)?'Servicio editado con éxito':'Servicio registrado con éxito'
        ];
    }

    public function destroy($id){
        try {            
            
            $bank = Service::findOrFail($id);
            $bank->delete(); 

            return [
                'success' => true,
                'message' => 'Servicio eliminada con éxito'
            ];

        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false,'message' => 'El servicio esta siendo usado por otros registros, no puede eliminar'] : ['success' => false,'message' => 'Error inesperado, no se pudo eliminar el servicio'];

        }
    }
}
