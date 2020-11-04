<?php

namespace App\CoreFacturalo\Requests\Inputs\Common;
use App\Models\Tenant\User as UserModel;

class UserInput{
    public static function set($user_id){
        $usuario = UserModel::find($user_id);

        return [

                'id' => $usuario->id,
                'name' => $usuario->name,
                'email' => $usuario->email,
                'type' => $usuario->type
        ];
    }
}