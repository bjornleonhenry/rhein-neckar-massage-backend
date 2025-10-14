<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'girl' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'message' => 'nullable|string',
            'specialRequests' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $booking = Booking::create([
            'girl' => $request->girl,
            'service' => $request->service,
            'date' => $request->date,
            'time' => $request->time,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message,
            'special_requests' => $request->specialRequests,
            'status' => 'pending',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vielen Dank für Ihre Buchungsanfrage! Wir werden uns innerhalb der nächsten 2 Stunden bei Ihnen melden, um den Termin zu bestätigen.',
            'data' => $booking
        ], 201);
    }
}
