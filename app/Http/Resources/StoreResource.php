<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            // 'id_user' => $this->user_id,
        //     'store' => $this->name_store,
        //     'status' => $this->status_store,
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        //     'count_produit' => 
        //     'count_client' => 
        ];
    }
}
