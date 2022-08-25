<?php

namespace App\Http\Resources\Tenant;

use App\Http\Resources\Tenant\ProduitCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource1 extends JsonResource
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
            'designation' => $this->name_store,
            'status' => $this->status_store,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'count_produit' => $this->produits->count(),
            'produits' => new ProduitCollection($this->produits),
        ];
    }
}
