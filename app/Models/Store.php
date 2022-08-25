<?php

namespace App\Models;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    //-- Relation Many To Many (Un Store peut etre utiliser par Plusieurs User) --
    public function users()
    {
        return $this->belongsToMany(User::class, 'store_user', 'user_id', 'store_id');
    }

    //-- Relation One To Many (Un Store appartienent a un User) --
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //-- Relation One To Many (Un store peut avoir plusieurs produits) --
    public function produits()
    {
        return $this->HasMany(Produit::class);
    }

    //__ Ajouter une Boutique __
    public function addStore_($request)
    {
        $store = new Store();
        $store->user_id = $request->user()->id;
        $store->name_store = $request->name_store;
        $store->save();

        return true;
    }

    public function updateStore_($id_store, $id_tenant, $data)
    {
        $update = Store::where('id', $id_store)
            ->where('user_id', $id_tenant)
            ->update($data);
        
        if(!$update){
            return false;
        }

        return true;
    }
}
