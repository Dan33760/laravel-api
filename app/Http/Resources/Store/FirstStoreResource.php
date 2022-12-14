<?php

namespace App\Http\Resources\Store;

use App\Http\Resources\User\FirstUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FirstStoreResource extends JsonResource
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
            'tenant' => new FirstUserResource($this->user),
            'designation' => $this->name_store,
            'status' => $this->status_store,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'count_produit' => $this->produits->count(),
            'count_client' => $this->users->count(),
        ];
    }
}
