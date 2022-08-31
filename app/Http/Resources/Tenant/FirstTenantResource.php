<?php

namespace App\Http\Resources\Tenant;

use App\Http\Resources\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Store\SecondStoreCollection;

class FirstTenantResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'image' => new ImageResource($this->image),
            'stores' => new SecondStoreCollection($this->stores_)
        ];
    }
}
