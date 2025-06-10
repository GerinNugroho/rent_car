<?php

namespace App\Http\Controllers;

use App\Http\Requests\requestCar;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CarController extends Controller
{
    public function index()
    {
        return response()->json(Car::all());
    }
    public function show($id)
    {
        try {
            $car = Car::findOrFail($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'status' => false,
                'message' => 'mobil tidak ditemukan',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'mobil ditemukan',
            'data' => $car
        ]);
    }
    public function store(requestCar $request)
    {
        $validated = $request->validated();
        $car = Car::create($validated);
        return response()->json([
            'status' => true,
            'message' => 'mobil berhasil disimpan',
            'data' => $car
        ], 201);
    }
    public function update(Request $request, $id)
    {
        try {
            $car = Car::findOrFail($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'status' => false,
                'message' => 'mobil tidak ditemukan',
            ], 404);
        }
        $car->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'mobil ditemukan',
            'data' => $car
        ]);
    }

    public function destroy($id)
    {
        try {
            $car = Car::findOrFail($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'status' => false,
                'message' => 'mobil tidak ditemukan'
            ], 404);
        }
        Car::findOrFail($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'mobil berhasil dihapus'
        ]);
    }
}
