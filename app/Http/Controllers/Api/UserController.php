<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->Gate::allows('access-admin');
    }
    //-- Profil User ----
    public function profilUser(Request $request)
    {
        // $response = Gate::inspect('access-admin');
        // if($response->allowed())
        // {
            $id = $request->user()->id;
            return new UserResource(User::find($id));
        // }else{
        //     return response([$response->message()]);
        // }

        // $id = $request->user()->id;
        // $user = User::with('role')->find($id);

        // return new UserResource(User::find($id));
        // return new UserCollection(User::paginate());
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
