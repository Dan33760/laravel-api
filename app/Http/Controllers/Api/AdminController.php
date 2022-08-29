<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\SecondUserCollection;
use App\Http\Resources\Store\FirstStoreCollection;

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
}
