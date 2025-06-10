<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UserController extends Controller
{
    public function index()
    {
        $data  = User::all();
        return response()->json(['data' => $data]);
    }
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'status' => false,
                'message' => 'user tidak ditemukan',
                'data' => $user
            ], 404);
        }
        return response()->json([$user]);
    }
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
        return response()->json([
            'status' => true,
            'message' => 'registrasi selesai',
            'data' => $user
        ], 201);
    }
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'status' => true,
                'message' => 'user tidak ditemukan'
            ], 404);
        }
        $user->update($request->all());
        return response()->json([
            'status' => false,
            'message' => 'user berhasil diupdate',
            'data' => $user
        ]);
    }
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'status' => false,
                'message' => 'user tidak ditemukan'
            ], 404);
        }
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'user berhasil dihapus',
        ]);
    }
}
