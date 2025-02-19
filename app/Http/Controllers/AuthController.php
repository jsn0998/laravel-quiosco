<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function register(RegistroRequest $request){
        $data = $request->validated();

        // Crear el usuario
        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
        ]);

        // Retornar una respuesta
        return [
            'token'=>$user->createToken('token')->plainTextToken,
            'user'=>$user
        ];
    }

    public function login(LoginRequest $request){
        $data = $request->validated();

        // Si las credenciales son incorrectas
        if(!Auth::attempt($data)){
            return response([
                'errors'=>['El email o el password son incorrectos']
            ],422);
        }

        // Autenticar el usuario
        $user =Auth::user();
        return [
            'token'=>$user->createToken('token')->plainTextToken,
            'user'=>$user
        ];
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return [
            'user'=>null
        ];
    }


}
