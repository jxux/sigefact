<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewersFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        return [

            'id' => $this->id,
            // 'user_id' => $this->user_id,
            // 'external_id' => $this->external_id,
            'date' => $this->date->format('d/m/Y'),
            'start_time' => $this->start_time->format('h:i a'),
            'end_time' => $this->end_time->format('h:i a'),
            'hour' => $this->hour,
            'client_id' => $this->client_id,
            'client' => $this->client->name,
            'category_id' => $this->category_id,
            'category' => $this->category->name,//->name,
            'service' => $this->service->name,//->name,
            'period' => $this->period->format('M/Y'),
            'service_id' => $this->service_id,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}
