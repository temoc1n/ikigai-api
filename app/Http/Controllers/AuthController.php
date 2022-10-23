<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Traits\HttpResponses;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if(!Auth::attempt($request->only(['email','password'])))
        {
            return $this->error('','Credentials do not match',401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->succes([
            'user' => $user,
            'token' => $user->createToken($user->name)->plainTextToken
        ]);
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
