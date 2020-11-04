<?php

namespace App\CoreFacturalo\Requests\Inputs\Common;
use App\Models\Tenant\Service as ServiceModel;

class ServiceInput{
    public static function set($service_id){
        $service = ServiceModel::find($service_id);

        return [

                'code' => $service->code,
                'name' => $service->name,

        ];
    }
}