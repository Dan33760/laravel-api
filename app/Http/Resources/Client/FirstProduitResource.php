<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FirstProduitResource extends JsonResource
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
            'produit' => $this->nom_produit,
            'prix_unitaire' => $this->pu_produit,
            'quantite' => $this->quantite_produit,
            'marge' => $this->marge,
            'status' => $this->status_produit,
            'created_at' => $this->created_at,
            'image' => new ImageResource($this->image),
        ];
    }
}
