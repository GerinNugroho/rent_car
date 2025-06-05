<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $data  = User::all();
        return response()->json(['data' => $data]);
    }
    public function show($id) {}
    public function store(StoreUserRequest $request)
    {
        $request->validated();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);
        return response()->json(['message' => 'Proses registrasi selasai!', 'data' => $user]);
    }
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
