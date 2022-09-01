<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\Access\Gate;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware( function ($request, $next) {
    //         if(!$request->user()->role->role === 'client') {
    //             return response([
    //                 'status' => false,
    //                 'message' => 'you must be client.'
    //             ]);
    //         }
    //         return $next($request);
    //     });
    // }

    public function __construct(Gate $gate)
    {
        // Since we're cool, we are using the new Arrow Function introduced in PHP 7.4.
        // For those who don't like the bleeding edge until it becomes 120% stable,
        // you can use a Closure. The only difference are the number of lines.
        $gate->define('see-dashboard', fn ($user) => $user->role->role == 'tenant');
        
        // Now, we can just simply call the authorization middleware like normal.
        $this->middleware('can:see-dashboard');
    }

    //-- Profil User ----
    public function profilUser(Request $request)
    {
        return new UserResource(User::find($request->user()->id));
    }

    //-- Ajouter Photo Profil --
    public function imageProfil(Request $request)
    {
        $validateImage = Validator::make($request->all(), [
            'image' => ['required', 'image:jpeg,png,jpg', 'max:2048']
        ]);

        if($validateImage->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation file Error',
                'error' => $validateImage->errors()
            ], 401);
        }

        $fileName = time() . '.' . $request->image->extension();
        $path = $request->file('image')->storeAs('profil', $fileName, 'public');
        $image = new Image(['url'=> $path]);

        $user = User::find($request->user()->id);
        $save = $user->image()->save($image);

        if(!$save) {
            return response(['status' => false, 'message' => 'Image non enregistrer']);
        }

        return response()->json([
            'status' => true,
            'message' => 'Image enregistrer'
        ], 200);
    }
}
