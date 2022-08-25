<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Store;
use App\Models\Panier;
use App\Models\PanierProduit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'nom_produit',
        'pu_produit',
        'quantite_produit',
        'marge'
    ];

    //-- Relation One To One (Polymorph) (Un produit avec une image) --
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    //-- Relation One To Many (Un produit appartient a un Store) --
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    //-- Relation Many To Many (Un produit peut etre dans plusieurs Paniers) --
    public function paniers()
    {
        return $this->belongsToMany(Panier::class)->using(PanierProduit::class);
    }

    //-- Ajouter un produit --
    public function addProduit_($request)
    {
        $produit = Produit::create([
            'store_id' => $request['store'],
            'nom_produit' => $request['nom_produit'],
            'pu_produit' => $request['pu_produit'],
            'quantite_produit' => $request['quantite_produit'],
            'marge' => $request['marge'],
        ]);

        return $produit;
    }

    public function updateProduit_($id, $data)
    {
        $produit = Produit::where('id', $id)
                        ->update($data);
        return $produit;
    }

}
