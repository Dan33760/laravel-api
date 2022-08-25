<?php

namespace App\Http\Controllers\Api;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\PanierProduit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PanierController extends Controller
{
    public function addPanier(Request $request)
    {
        $validatePanier = Validator::make($request->all(), [
            'designation' => 'required|min:3|max:20',
            'produit_id' => 'required|integer',
            'quantite' => 'required|integer'
        ]);

        if($validatePanier->fails()) {
            return response([
                'status' => false,
                'message' => 'Erreur Validation',
                'errors' => $validatePanier->errors()
            ]);
        }

        $panier = Panier::addPanier($request->designation);

        for($i = 0; $i < count($request->produit_id); $i++)
        {
            $produit = Produit::where('id', $request->produit_id)->first();
            $produits [] = [
                'panier_id' => $panier,
                'produit_id' => $request->produit_id,
                'quantite_produit' => $request->quantite,
                'prix_total' => $request->quantite * $produit->pu_produit
            ];
        }

        $panierProduit = PanierProduit::insert($produits);

        return response([
            'status' => true,
            'message' => 'Panier Ajouté'
        ]);
    }
}
