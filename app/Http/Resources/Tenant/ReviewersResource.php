<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewersResource extends JsonResource
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
            'date' => $this->date->format('Y-m-d'),
            'start_time' => $this->start_time->format('Y-m-d h:i:s'),
            'end_time' => $this->end_time->format('Y-m-d h:i:s'),
            'hour' => $this->hour,
            'client_id' => $this->client_id,
            // 'client' => $this->client,
            'category_id' => $this->category_id,
            'period' => $this->period->format('Y-m-d'),
            'service_id' => $this->service_id,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}
