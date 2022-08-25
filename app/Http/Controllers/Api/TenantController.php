<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Http\Resources\StoreCollection;
use App\Http\Resources\Tenant\StoreResource1;
use App\Http\Resources\Tenant\ProduitResource;
use App\Http\Resources\Tenant\FirstProduitResource;
use App\Http\Resources\Tenant\TenantStoreCollection;

class TenantController extends Controller
{
    //__ Recuperer les boutiques du tenant connecté __
    public function getStoresTenant(Request $request)
    {
        return new TenantStoreCollection(Store::where('user_id', $request->user()->id)
                                            ->with('produits')
                                            ->with('users')
                                            ->paginate());
    }

    //__ Recuperer un produit __
    public function getProduit($id)
    {
        return new FirstProduitResource(Produit::findOrFail($id));
    }

    //__ Recuperer une Boutique et ses Produit __
    public function getStore(Request $request, $id)
    {
        return new StoreResource1(Store::where('user_id', $request->user()->id)->find($id));
    }
}
