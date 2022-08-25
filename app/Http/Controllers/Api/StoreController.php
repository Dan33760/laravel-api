<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreCollection;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Tenant\TenantStoreCollection;
// use App\Http\Resources\TenantStoreCollection;

class StoreController extends Controller
{
    public function addStore(Request $request)
    {
        $validateStore = Validator::make($request->all(),[
            'name_store' => 'required|min:3|max:50'
        ]);

        if($validateStore->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Erreur Validation',
                'error' => $validateStore->errors()
            ], 401);
        }

        Store::addStore_($request);
        
        return response([
            'status' => true,
            'message' => 'Boutique Ajoutéé'
        ]);

    }

    //__ Modifier Une Boutique __
    public function updateStore(Request $request, $id_store)
    {
        $validateStore = Validator::make($request->all(),[
            'name_store' => 'required|min:3|max:50'
        ]);

        if($validateStore->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Erreur Validation',
                'error' => $validateStore->errors()
            ], 401);
        }
        $data = ['name_store' => $request->name_store];
        $update = Store::updateStore_($id_store, $request->user()->id, $data);

        if(!$update){
            return response([
                'status' => false,
                'message' => 'Boutique non Modifiée'
            ]);
        }
        
        return response([
            'status' => true,
            'message' => 'Boutique Modifiée'
        ]);
    }

    //__ Activer Ou Desactiver une Boutique __
    public function updateStatus(Request $request, $id_store)
    {
        $store = Store::find($request->id);
        if(!$store) {
            return response()->json([
                'message' => 'boutique non trouver'
            ]);
        }

        $data = [];
        if($store->status_store === 1) {
            $data = ['status_store' => 0];
            $message = 'Boutique Desactivéé';
        }

        if($store->status_store === 0) {
            $data = ['status_store' => 1];
            $message = 'Boutique Activée';
        }

        $update = Store::updateStore_($id_store, $request->user()->id, $data);

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

    //__ Supprimer Une Boutique __
    public function deleteStore(Request $request)
    {
        $delete = Store::where('id', $request->id)
                        ->where('user_id', $request->user()->id)
                        ->delete();

        if(!$delete){
            return response([
                'status' => false,
                'message' => 'Boutique non Trouver'
            ]);
        }
        
        return response([
            'status' => true,
            'message' => 'Boutique Supprimeée'
        ]);
    }
}
