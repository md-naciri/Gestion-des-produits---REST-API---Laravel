<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $register = $request->all();
        $register['password'] = Hash::make($register['password']);
        $user = User::create($register);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);

    }

    public function login(LoginRequest $request)
    {
        if(!Auth::attempt($request->all())){
            return response()->json(['error' => 'Invalid credentials', 401]);
        }
        $user = auth()->user();
        $token = auth()->user()->createToken('auth_token')->plainTextToken;

        return response()->json([
            'username' => $user->name,
            'email' => $user->email,
            'access_token' => $token,
        ]);
    }

    public function update(RegisterRequest $request, User $user)
    {
        $toUpdate = $request->all();
        $toUpdate['password'] = Hash::make($request->password);
        $user->update($toUpdate);
        return response([
            'message' => 'Profile updated successfully!'
        ], 200);
    }
}
