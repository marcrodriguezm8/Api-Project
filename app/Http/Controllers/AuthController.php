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
}
