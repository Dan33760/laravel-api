<?php

namespace App\Http\Resources\Panier;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Produit\FirstProduitCollection;

class SecondPanierResource extends JsonResource
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
            'panier' => $this->nom_panier,
            'status' => $this->status_panier,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'count_produits' => $this->produits->count(),
            'produits' => new FirstProduitCollection($this->produits)
        ];
    }
}
