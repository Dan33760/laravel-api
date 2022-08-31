<?php

namespace App\Http\Resources\Produit;

use Illuminate\Http\Resources\Json\JsonResource;

class SecondProduitResource extends JsonResource
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
            'pix_unitaire' => (float) $this->pu_produit,
            'quantite' => $this->quantite_produit,
            'marge' => $this->marge,
            'status' => $this->status_produit,
            'create_at' => $this->created_at
        ];
    }
}
