<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Store\FirstStoreResource;
use App\Http\Resources\Store\ThirdStoreResource;
use App\Http\Resources\User\SecondUserCollection;
use App\Http\Resources\Store\FirstStoreCollection;
use App\Http\Resources\Tenant\FirstTenantResource;

class AdminController extends Controller
{
    //__ Recuperer tous les Utilisateur __
    public function getUsers(Request $request)
    {
        return new SecondUserCollection(User::paginate());
    }

    //__ Recuperer toutes les Boutiques __
    public function getStores(Request $request)
    {
        return new FirstStoreCollection(Store::paginate());
    }

    //__ Recuperer les bouttiques d'un tenant __
    public function getStoresTenant($id)
    {
        return new FirstTenantResource(User::find($id));
    }

    //__ Recuperer les Details Pour une Boutique __
    public function getDetailsStore($id)
    {
        return new ThirdStoreResource(Store::find($id));
    }
}
