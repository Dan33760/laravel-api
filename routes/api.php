<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\PanierController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\ProduitController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'registerUser']);
Route::post('/login', [AuthController::class, 'loginUser']);
Route::get('/profil', [UserController::class, 'profilUser'])->middleware('auth:sanctum');
Route::post('/image_profil', [UserController::class, 'imageProfil'])->middleware('auth:sanctum');

//__ Routes Pour l'Admin __
Route::middleware('auth:sanctum')->prefix('admin')->group( function () {
    Route::get('/get_users', [AdminController::class, 'getUsers']);
    Route::get('/get_stores', [AdminController::class, 'getStores']);
    Route::get('/get_store_tenant/{id}', [AdminController::class, 'getStoresTenant']);
    Route::get('/get_details_store/{id}', [AdminController::class, 'getDetailsStore']);
});

//__ Routes Pour le Tenant __
Route::middleware('auth:sanctum')->prefix('tenant')->group( function () {
    Route::post('/add_store', [StoreController::class, 'addStore']);
    Route::post('/update_store/{id}', [StoreController::class, 'updateStore']);
    Route::get('/update_status/{id}', [StoreController::class, 'updateStatus']);
    Route::delete('/delete_store/{id}', [StoreController::class, 'deleteStore']);

    Route::post('/add_produit', [ProduitController::class, 'addProduit']);
    Route::post('/update_produit/{id}', [ProduitController::class, 'updateProduit']);
    Route::delete('/delete_produit/{id}', [ProduitController::class, 'deleteProduit']);
    Route::get('/status_produit/{id}', [ProduitController::class, 'updateStatus']);

    Route::get('/get_stores', [TenantController::class, 'getStoresTenant']);
    Route::get('/get_produit/{id}', [TenantController::class, 'getProduit']);
    Route::get('/get_store/{id}', [TenantController::class, 'getStore']);
});

//__ Routes Pour Le Client __
Route::middleware('auth:sanctum')->prefix('client')->group( function () {
    Route::get('/get_stores', [ClientController::class, 'getStores']);
    Route::get('/register_store/{id}', [ClientController::class, 'registerStore']);
    Route::get('/get_client_store', [ClientController::class, 'getClientStore']);
    Route::get('/get_produit_store/{id}', [ClientController::class, 'getProduitByStore']);
    Route::get('/get_panier', [ClientController::class, 'getPanier']);

    Route::get('/valider_panier/{id}', [PanierController::class, 'validerPanier']);
    Route::post('/add_panier', [PanierController::class, 'addPanier']);
    Route::post('/update_panier/{id}', [PanierController::class, 'updatePanier']);
    Route::get('/get_panier/{id}', [PanierController::class, 'getPanier']);
    Route::get('/remove_produit/{id_panier}/{id_produit}', [PanierController::class, 'removeProduit']);
});


