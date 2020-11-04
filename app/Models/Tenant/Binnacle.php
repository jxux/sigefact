<?php

namespace App\Models\Tenant;
use Hyn\Tenancy\Traits\UsesTenantConnection;

// use App\Models\Tenant\Category;
// use App\Models\Tenant\Service;

// use Illuminate\Database\Eloquent\Model;

class Binnacle extends ModelTenant{
    use UsesTenantConnection;

    // protected $table = 'Binnacles';
    // protected $with = ['category_binnacles', 'service_binnacles'];
    protected $with = ['user'];


    protected $fillable = [
        'user_id',
        'user',
        'external_id',
        'date',
        'start_time',
        'end_time',
        'hour',
        'client_id',
        'client',
        'category_id',
        'category',
        'period',
        'service_id',
        'service',
        'description',
        'status',
        'status_Re',
        'date_Re_Ve',
        'description_Re'

    ];

    protected $casts = [
        // 'start_time' => 'datetime',
        // 'end_time' => 'times',
        // 'date' => 'date',
        // 'created_at'=> 'date',
        // 'updated_at'=> 'date',
    ];

    protected $dates = [
        'date',
        'period',
        'start_time',
        'end_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getClientAttribute($value){
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setClientAttribute($value){
        $this->attributes['client'] = (is_null($value))?null:json_encode($value);
    }

    public function Client() {
        return $this->belongsTo(CurrencyType::class, 'client_id');
    }




    public function getCategoryAttribute($value){
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setCategoryAttribute($value){
        $this->attributes['category'] = (is_null($value))?null:json_encode($value);
    }

    public function Category() {
        return $this->belongsTo(Category::class, 'category_id');
    }



    public function getServiceAttribute($value){
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setServiceAttribute($value){
        $this->attributes['service'] = (is_null($value))?null:json_encode($value);
    }

    public function Service() {
        return $this->belongsTo(Service::class, 'service_id');
    }



    public function getUserAttribute($value){
        return (is_null($value))?null:(object) json_decode($value);
    }

    public function setUserAttribute($value){
        $this->attributes['user'] = (is_null($value))?null:json_encode($value);
    }

    // public function User() {
    //     return $this->belongsTo(User::class, 'user_id');
    // }



    // public function user(){
    //     return $this->belongsTo(User::class);
    // }
}
