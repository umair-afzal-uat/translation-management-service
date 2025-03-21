<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getToken()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test'.time().'@example.com',
            'password' => Hash::make('password'),
        ]);
        
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [];
        $response['token'] = $token;

        return response()->json($response);
    }
}