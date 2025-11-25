<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\BookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Store a new booking and send notification email.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'girl' => 'nullable|string|max:255',
            'service' => 'required|string|max:255',
            'date' => 'required|date|after:today',
            'time' => 'required|string|regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/',
            'duration' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'message' => 'nullable|string|max:1000',
            'specialRequests' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $bookingData = $validator->validated();

        try {
            // Send email notification
            Mail::to('Info@Rhein-Neckar-Massage.de')->send(new BookingNotification($bookingData));

            return response()->json([
                'message' => 'Buchungsanfrage erfolgreich gesendet. Wir werden uns in Kürze bei Ihnen melden.',
                'data' => $bookingData
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Booking email failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Buchungsanfrage konnte nicht gesendet werden. Bitte versuchen Sie es später erneut.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
