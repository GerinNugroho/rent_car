<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => [
                    $validator->errors()
                ]
            ], 400);
        }
        $car = Car::where('id', $request->car_id)->first();
        if ($car && !($car->status == 'available')) {
            return response()->json([
                'status' => false,
                'message' => 'mobil tidak tersedia'
            ], 204);
        }

        $car->status = 'unavailable';

        $car->save();

        $start = Carbon::now();

        $end = Carbon::now()->addDays(5);

        $booking = [
            'user_id' => $request->user()->id,
            'car_id' => $request->car_id,
            'fullname' => $request->fullname ?? $request->user()->name,
            'email' => $request->user()->email,
            'number_phone' => $request->user()->phone_number,
            'start_date' => $start,
            'end_date' => $end
        ];

        Booking::create($booking);

        return response()->json([
            'message' => 'Mobil berhasil di booking!',
            'data' => $booking
        ]);
    }

    public function index()
    {
        $bookings = Booking::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'message' => 'List Booking',
            'data' => $bookings
        ]);
    }
}
