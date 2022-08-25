<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{
    //__ Ajouter Un Produit __
    public function addProduit(Request $request)
    {
        $validateProduit = Validator::make($request->all(), [
            'image' => ['required', 'image:jpeg,png,jpg', 'max:2048'],
            'store' => ['required'],
            'nom_produit' => ['required', 'min:3', 'max:50', 'unique:produits,nom_produit'],
            'pu_produit' => ['required', 'integer', 'min:1'],
            'quantite_produit' => ['required'],
            'marge' => ['required', 'integer'],
        ]);

        if($validateProduit->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Erreur Validation',
                'error' => $validateProduit->errors()
            ], 401);
        }

        $filename = time() . '.' . $request->image->extension();
        $path = $request->file('image')->storeAs('produits', $filename, 'public');
        $image = new Image(['url' => $path]);

        $produit = Produit::addProduit_($request->all());
        $save = $produit->image()->save($image);

        if(!$save) {
            return response(['status' => false, 'message' => 'Produit non enregistrer']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Produit enregistrer',
        ], 200);
    }

     //__ Modifier Un Produit __
     public function updateProduit(Request $request, $id_store)
     {
        if(!Produit::find($id_store)) {
            return response()->json([
                'status' => false,
                'message' => 'Produit non Trouvé'
            ], 401);
        }

        $validateProduit = Validator::make($request->all(), [
            'nom_produit' => ['required', 'min:3', 'max:50'],
            'pu_produit' => ['required', 'integer', 'min:1'],
            'quantite_produit' => ['required'],
            'marge' => ['required', 'integer'],
        ]);

        if($validateProduit->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Erreur Validation',
                'error' => $validateProduit->errors()
            ], 401);
        }

        $data = [
            'nom_produit' => $request->nom_produit,
            'pu_produit' => $request->pu_produit,
            'quantite_produit' => $request->quantite_produit,
            'marge' => $request->marge
        ];

        $produit = Produit::updateProduit_($id_store, $data);

        if(!$produit) {
            return response()->json([
                'status' => false,
                'message' => 'produit non modifier'
            ], 401);
        }
 
        return response()->json([
            'status' => true,
            'message' => 'Produit Modifier',
        ], 200);
    }

    //__ Supprimer un produit __
    public function deleteProduit($id)
    {
        $produit = Produit::find($id);

        if(!$produit) {
            return response()->json([
                'status' => false,
                'message' => 'Produit non Trouvé'
            ], 401);
        }

        $produit->delete();
        
        return response()->json([
            'status' => false,
            'message' => 'Produit Supprimé'
        ], 200);

    }

    //__ Activer Ou Desactiver un Produit __
    public function updateStatus($id)
    {
        $produit = Produit::find($id);
        
        if(!$produit) {
            return response()->json([
                'message' => 'Produit non trouver'
            ]);
        }

        $data = [];
        if($produit->status_produit === 1) {
            $data = ['status_produit' => 0];
            $message = 'Produit Desactivéé';
        }

        if($produit->status_produit === 0) {
            $data = ['status_produit' => 1];
            $message = 'Produit Activée';
        }

        $update = Produit::updateProduit_($id, $data);

        if(!$update){
            return response([
                'status' => false,
                'message' => 'Erreur'
            ]);
        }
        
        return response([
            'status' => true,
            'message' => $message
        ]);
    }

    //__ Verifier si le produit existe __
    public function verifProduit($id)
    {
        $produit = Produit::find($id); 
        if(!$produit) {
            return false;
        }
        return true;
    }
}
