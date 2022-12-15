<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
        'name' => 'required',
        'email' => 'required|unique:users',
        'password' => 'required'
        ]);

        $user = User::create(['name'=> $request->name, 'email' => $request->email, 'password' => Hash::make($request->password)]);
        return ['token' => $user->createToken('my-token')->plainTextToken];

        return $user;
    }


    public function login(Request $request) {
        $request->validate([
        'email' => 'required',
        'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
 
        if (! $user || ! Hash::check($request->password, $user->password)) {

            return ['error' => 'The provided credentials are incorrect.'];
        }
     
        return ['token' => $user->createToken('my-token')->plainTextToken];
    }
}
