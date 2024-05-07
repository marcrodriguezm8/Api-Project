<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login (Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('api-project')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }
        else {
            return response()->json(['Invalid credentials'], 401);
        }
    }

    public function register(Request $request){
        $credentials = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'confirm-password' => 'required|string'
        ]);

        if($credentials['password'] === $credentials['confirm-password']){
            $users = User::where('email', $request->email)->get();

            if(sizeof($users) == 0){
                User::create($credentials);
                return response()->json(['Usuario creado con éxito'], 200);
            }
            else{
                return response()->json(['El email ya está en uso'], 401);
            }
        }
        else {
            return response()->json(['Contraseñas no coinciden'], 401);
        }
    }
}
