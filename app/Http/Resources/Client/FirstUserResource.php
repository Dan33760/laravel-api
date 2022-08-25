<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Client\FirstClientStoreResource;
use App\Http\Resources\Client\FirstClientStoreCollection;

class FirstUserResource extends JsonResource
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
            'client' => $this->name,
            'email' => $this->email,
            'stores' => new FirstClientStoreCollection($this->stores)
        ];
    }
}
