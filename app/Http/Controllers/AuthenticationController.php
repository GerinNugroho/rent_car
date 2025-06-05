<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'message' => 'Gagal login!'
            ]);
        };

        $token = $user->createToken('Token Login')->plainTextToken;

        return response()->json([
            'message' => 'Berhasil Login!',
            'token' => "Bearer " . $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => "Berhasil logout!"
        ]);
    }

    public function profile()
    {
        return response()->json([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone_number' => Auth::user()->phone_number,
            'role' => Auth::user()->role
        ]);
    }
}
