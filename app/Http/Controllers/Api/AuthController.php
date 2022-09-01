<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\UserRegisteredNotification;

class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        try{
            //-- Validation
            $validateUser = Validator::make($request->all(), [
                'role' => ['required', 'integer'],
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:6', 'max:255']
            ]);

            //-- Verification Validation
            if($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'error' => $validateUser->errors()
                ], 401);
            }

            //-- Create User
            $user = User::saveUser($request);

            // $user->notify(new UserRegisteredNotification());

            return response()->json([
                'status' => true,
                'message' => 'Utilisateur Créé Avec Succes'
            ], 200);
        }
        catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    //-- Login 
    public function LoginUser(Request $request)
    {
        try{
            //-- Validation
            $validateLogin = Validator::make($request->all(),[
                'email' => ['required', 'email'],
                'password' => ['required']
            ]);

            //-- Verification Validation
            if($validateLogin->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erreur Validation',
                    'errors' => $validateLogin->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'L\'adresse mail ou le mot de passe est incorrecte',
                ], 400);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'Utilisateur Connecté',
                'token' => $user->createToken('API TOKEN')->plainTextToken
            ], 200);
        }
        catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
