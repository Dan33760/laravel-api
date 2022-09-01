<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\Panier;
use App\Models\StoreUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Client\FirstUserResource;
use App\Http\Resources\Client\FirstStoreResource;
use App\Http\Resources\Panier\SecondPanierCollection;
use App\Http\Resources\Client\FirstClientStoreCollection;

class ClientController extends Controller
{
    //__ Recuperer les boutiques du client __
    public function getClientStore(Request $request)
    {
        return new FirstUserResource(User::find($request->user()->id));
        // return User::with('stores')->find($request->user()->id);
    }

    //__ Recuperer Les Produits D'une Boutique __
    public function getProduitByStore($id)
    {
        return new FirstStoreResource(Store::find($id));
    }

    //__ Recuperer les Paniers d'un Client
    public function getPanier(Request $request)
    {
        return new SecondPanierCollection(Panier::where('user_id', $request->user()->id)->get());
        // return $request->user();
    }

    //__ Recuperer Toute les Boutique __
    public function getStores()
    {
        return new FirstClientStoreCollection(Store::where('status_store', true)->paginate());
    }

    //__ Ajouter un client a une Boutique __
    public function registerStore(Request $request, $id)
    {
        $userExist = StoreUser::where('user_id', $request->user()->id)->where('store_id', $id)->first();

        if($userExist) {
            return response()->json([
                'status' => false,
                'message' => 'Vous etes deja Client'
            ], 401);
        }

        $register = StoreUser::create([
            'user_id' => $request->user()->id,
            'store_id' => $id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Client ajouter'
        ], 200);
    }
}
