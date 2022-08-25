<?php

namespace App\Models;

use App\Models\User;
use App\Models\Produit;
use App\Models\PanierProduit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Panier extends Model
{
    use HasFactory;

    //-- Relation One To Many (Un panier pour un User)----
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //-- Relation Many To Many (Un panier peut avoir plusieurs Produit) --
    public function produits()
    {
        return $this->belongsToMany(Produit::class)->using(PanierProduit::class);
    }

    //-- Ajouter un Panier --
    public function addPanier($designation)
    {
        $panier = Panier::create([
            'nom_panier' => $designation
        ]);

        return $panier;
    }


}
