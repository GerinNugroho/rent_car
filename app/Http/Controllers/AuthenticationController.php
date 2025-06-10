<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\requestAuthenticator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(requestAuthenticator $request)
    {
        $validated = $request->validated();
        if (!Auth::attempt($validated)) {
            return response()->json([
                'status' => false,
                'message' => 'user tidak ditemukan!'
            ]);
        }

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('Token Login')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'berhasil login',
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'berhasil logout!'
        ]);
    }

    public function profile()
    {
        return response()->json([
            'status' => true,
            'data' => [
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone_number' => Auth::user()->phone_number,
                'role' => Auth::user()->role
            ]
        ]);
    }
}
