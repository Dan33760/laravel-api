<?php

namespace App\Http\Resources\Produit;

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
            'pix_unitaire' => (float) $this->pu_produit,
            'panier_detail' => $this->pivot
        ];
    }
}
