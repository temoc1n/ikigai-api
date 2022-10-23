<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function login()
    {
        return 'Login Methods here :P';
    }

    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->succes([
            'user' => $user,
            'token' => $user->createToken($user->name)->plainTextToken
        ]);
    }

    public function logout() 
    {
        return response()->json('This is my logout method');
    }
}
