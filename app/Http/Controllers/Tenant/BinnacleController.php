<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Person;
use App\Models\Tenant\Company;

use App\Models\Tenant\Binnacle;
use App\Http\Resources\Tenant\BinnacleCollection;
use App\Http\Resources\Tenant\BinnacleResource;
use App\Http\Requests\Tenant\BinnacleRequest;

use App\Models\Tenant\Category;
use App\Models\Tenant\Service;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\CoreFacturalo\Requests\Inputs\Common\PersonInput;
use App\CoreFacturalo\Requests\Inputs\Common\CategoryInput;
use App\CoreFacturalo\Requests\Inputs\Common\ServiceInput;
use App\CoreFacturalo\Requests\Inputs\Common\UserInput;

use App\Exports\BinnacleExport;
use Maatwebsite\Excel\Excel;
use Carbon\Carbon;

class BinnacleController extends Controller{

    public function index(){
        return view('tenant.binnacles.index');
    }

    public function catalogs(){
        return view('tenant.binnacles.catalog.index');     
    }

    public function columns(){
        return [
            'description' => 'Descripción',
            'client' => 'Cliente',
            'category' => 'Categoría',
            'service' => 'Servicio',
        ];
    }

    public function records(Request $request){
        $records = Binnacle::where('user_id', auth()->id())
                            ->where($request->column, 'like', "%{$request->value}%")
                            ->orderBy('date','desc')
                            ->orderBy('end_time','desc');

        return new BinnacleCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function tables(){
        $clients = $this->table('clients');
        $categorys = $this->table('categorys');
        $services = $this->table('services');

        // $company = Company::active();

        return compact('clients', 'categorys', 'services');
    }

    public function table($table){
        switch ($table) {
            case 'clients':
                $clients = Person::whereType('clients')->orderBy('code')->get()->transform(function($row) {
                    return [
                        'id' => $row->id,
                        'code' => $row->code,
                        'description' =>$row->code.' - '.$row->number.' - '.$row->name,
                        'name' => $row->name,
                        'number' => $row->number,
                    ];
                });
                return $clients;
                break;

            case 'categorys':
                $categorys = Category::get()->transform(function($row){
                    return [
                        'id' => $row->id,
                        'code' => $row->code,
                        'name' => $row->name,
                        'description' =>$row->code.' - '.$row->name,
                    ];
                });
               return $categorys;
                break;
            
            case 'services':
                $services = Service::get()->transform(function($row){
                    return [
                        'id' => $row->id,
                        'category' => $row->category_id,
                        // 'name' => $row->name,
                        'description' =>$row->code.' - '.$row->name,
                    ];
                });
                return $services;
                break;
            
            default:

                return [];

                break;
        }
    }

    public function create(){
        return view('tenant.binnacles.form');
    }

    public function store(BinnacleRequest $request){
        $data = self::convert($request);

        $id = $request->input('id');

        
        $event = Binnacle::firstOrNew(['id' => $id]);
        
        // $event = $request->auth()->id();
        // $event->fill($request->all());

        $event->fill($request->all());

        $event->save();

        return [
            'success' => true,
            'message' => ($id)?'Evento editado con éxito':'Evento registrado con éxito',
            'id' => $event->id
        ];
    }

    public static function convert($inputs){
        $company = Company::active();
        $user_id = auth()->id();
        $values = [
            'user_id' => auth()->id(),
            'external_id' => Str::uuid()->toString(),
            'client' => PersonInput::set($inputs['client_id']),
            'category' => CategoryInput::set($inputs['category_id']),
            'service' => ServiceInput::set($inputs['service_id']),
            'user' => UserInput::set($user_id),
        ]; 

        $inputs->merge($values);

        return $inputs->all();
    }

    public function record($id){

        $record = new BinnacleResource(Binnacle::findOrFail($id));

        return $record;
    }

    public function export(Request $request){

        $date = $request->month_start.'-01';
        $start_date = Carbon::parse($date);
        $end_date = Carbon::parse($date)->addMonth()->subDay();
        // dd($start_date.' - '.$end_date);

        $records = Binnacle::whereBetween('created_at', [$start_date, $end_date])->get();
        // dd(new BinnacleCollection($records));

        return (new BinnacleExport)
                ->records($records)
                ->download('Reporte_Bitacora_'.Carbon::now().'.xlsx');
    }

    public function destroy($id){
    try {   
            $event = Binnacle::findOrFail($id);
            // $this->deleteRecordInitialKardex($item);
            $event->delete();

            return [
                'success' => true,
                'message' => 'Evento eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false,'message' => 'El evento esta siendo usado por otros registros, no puede eliminar'] : ['success' => false,'message' => 'Error inesperado, no se pudo eliminar el evento'];

        }
    }
}