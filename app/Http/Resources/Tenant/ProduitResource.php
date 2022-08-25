<?php

namespace App\Http\Resources\Tenant;

use App\Http\Resources\ImageResource;
use App\Http\Resources\Tenant\StoreResource2;
use Illuminate\Http\Resources\Json\JsonResource;

class ProduitResource extends JsonResource
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
            'designation' => $this->nom_produit,
            'prix_unitaire' => $this->pu_produit,
            'quantite' => $this->quantite_produit,
            'marge' => $this->marge,
            'status' => $this->status_produit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'image' => new ImageResource($this->image),
        ];
    }
}
