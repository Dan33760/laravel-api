<?php

namespace App\Http\Resources\Panier;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Produit\FirstProduitCollection;

class ThirdPanierResource extends JsonResource
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
            'user_id' => $this->user_id,
            'panier' => $this->nom_panier,
            'status' => $this->status_panier,
            'produits' => new FirstProduitCollection($this->produits)
        ];
    }
}
