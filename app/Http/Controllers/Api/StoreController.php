<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
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

        $response = Gate::inspect('access-tenant');
        if($response->allowed()) {
            Store::addStore_($request->all());
            
            return response([
                'status' => true,
                'message' => 'Boutique Ajoutéé'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $response->message()
            ], 404);
        }
        

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

        $store = Store::find($id_store);
        $response = Gate::inspect('update', $store);
        if ($response->allowed()) {
            // Store::updateStore_($id_store, $request->all());
            $store->name_store = $request->name_store;
            $store->update();

            return response([
                    'status' => true,
                    'message' => 'Boutique Modifiée'
                ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $response->message()
            ], 404);
        }
    }

    //__ Activer Ou Desactiver une Boutique __
    public function updateStatus(Request $request, $id_store)
    {
        $store = Store::find($id_store);
        $response = Gate::inspect('update', $store);

        $data = [];
        $message = null;
        if($store->status_store === 1) {
            $data = ['status_store' => 0];
            $message = 'Boutique Desactivéé';
        }

        if($store->status_store === 0) {
            $data = ['status_store' => 1];
            $message = 'Boutique Activée';
        }

        if ($response->allowed()) {
            Store::where('id', $id_store)->update($data);
            return response([
                    'status' => true,
                    'message' => $message
                ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $response->message()
            ], 404);
        }
    }

    //__ Supprimer Une Boutique __
    public function deleteStore($id_store)
    {
        $store = Store::find($id_store);
        $response = Gate::inspect('delete', $store);
        if ($response->allowed()) {
            $delete = Store::where('id', $id_store)->delete();

            return response([
                'status' => true,
                'message' => 'Boutique Supprimeée'
                ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $response->message()
            ], 404);
        }
    }
}
