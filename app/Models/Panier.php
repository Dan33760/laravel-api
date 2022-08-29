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

    protected $fillable = ['user_id','nom_panier', 'created_at', 'updated_at'];

    //-- Relation One To Many (Un panier pour un User)----
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //-- Relation Many To Many (Un panier peut avoir plusieurs Produit) --
    public function produits()
    {
        return $this->belongsToMany(Produit::class)
                    ->using(PanierProduit::class)
                    ->withPivot('quantite_produit', 'prix_total');
        // return $this->belongsToMany(Produit::class)->withPivot('produit_id', 'quantite_produit', 'prix_total');
    }

    //-- Ajouter un Panier --
    public function addPanier($client, $designation)
    {
        $panier = Panier::create([
            'user_id' => $client,
            'nom_panier' => $designation
        ]);

        return $panier;
    }

    //-- Modifier un Panier --
    public function updatePanier($panier, $client, $data)
    {
        $panier = Panier::where('id', $panier)
                        ->where('user_id', $client)
                        ->update($data);

        return true;
    }

    //-- Recuperer un Panier --
    public function getPanier($client, $panier_id)
    {
        $panier = Panier::where('user_id', $client)
                        ->find($panier_id);
        return $panier;
    }


}
