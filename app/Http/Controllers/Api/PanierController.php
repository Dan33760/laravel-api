<?php

namespace App\Http\Controllers\Api;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\PanierProduit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Panier\FirstPanierResource;
use App\Http\Resources\Panier\ThirdPanierResource;

class PanierController extends Controller
{
    //__ Recuperer Les Details d'un Panier __
    public function getPanier($id_panier)
    {
        return new FirstPanierResource(Panier::find($id_panier));
    }

    //__ Retirer un Produit du Panier __
    public function removeProduit($id_panier, $id_produit)
    {
        $panier = Panier::find($id_panier);
        $panier->produits()->detach($id_produit);

        return response([
            'status' => true,
            'message' => 'produit retiré'
        ]);
    }

    //__ Ajouter Un Panier __
    public function addPanier(Request $request)
    {
        $validatePanier = Validator::make($request->all(), [
            'designation' => 'required|min:3|max:20',
            'produit_id.*' => 'required|integer|distinct',
            'quantite.*' => 'required|integer'
        ]);

        if($validatePanier->fails()) {
            return response([
                'status' => false,
                'message' => 'Erreur Validation',
                'errors' => $validatePanier->errors()
            ]);
        }

        $user_id = (int) $request->user()->id;
        $panier = Panier::addPanier($user_id,$request->designation);
        $produits = [];
        foreach($request->produit_id as $i => $id)
        {
            $produit = Produit::where('id', $request->produit_id[$i])->first();
            $produits[] = [
                'panier_id' => $panier->id,
                'produit_id' => (int) $request->produit_id[$i],
                'quantite_produit' => (int) $request->quantite[$i],
                'prix_total' => $request->quantite[$i] * $produit->pu_produit,
            ];
        }

        $panierProduit = PanierProduit::insert($produits);

        return response([
            'status' => true,
            'message' => 'Panier Ajouté'
        ]);
    }

    //__ Modifier Le Panier __
    public function updatePanier(Request $request, $id_panier)
    {
        $validatePanier = Validator::make($request->all(), [
            'designation' => 'required|min:3|max:20',
            'produit_id.*' => 'required|integer|distinct',
            'quantite.*' => 'required|integer'
        ]);

        if($validatePanier->fails()) {
            return response([
                'status' => false,
                'message' => 'Erreur Validation',
                'errors' => $validatePanier->errors()
            ]);
        }

        $data = ['nom_panier' => $request->designation];

        $panier = Panier::updatePanier($id_panier, $request->user()->id ,$data);
        // $produits = [];
        foreach($request->produit_id as $i => $id)
        {
            $produit = Produit::find($request->produit_id[$i]);
            $produits = [
                'quantite_produit' => (int) $request->quantite[$i],
                'prix_total' => $request->quantite[$i] * $produit->pu_produit,
            ];

            $save = $produit->paniers()->updateExistingPivot($id_panier, $produits);
            
        } 

        if(!$save) {
            return response(['message' => 'Echec']);

        }

        return response([
            'status' => true,
            'message' => 'Panier modifié'
        ]);
    }

    //__ Valider un Panier
    public function validerPanier($id)
    {
        $panier = new ThirdPanierResource(Panier::find($id));

        foreach($panier->produits as $produit)
        {
            $quantiteReste = [
                'quantite_produit' => $produit->quantite_produit - $produit->pivot->quantite_produit
            ];

            $produit = Produit::updateProduit_($produit->id, $quantiteReste);
        }

        $panier = Panier::updatePanier($id, $panier->user_id, ['status_panier' => true]);

        return response([
            'status' => true,
            'message' => 'panier validé'
        ]);
    }
}
