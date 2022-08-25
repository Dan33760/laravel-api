<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class FirstClientStoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'stores';
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'designation' => $this->name_store,
            'count_produit' => $this->produits->count(),
            'count_client' => $this->users->count()
        ];
    }
}
