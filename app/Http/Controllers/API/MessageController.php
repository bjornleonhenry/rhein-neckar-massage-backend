<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Store a new contact message and send notification email.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'service' => 'nullable|string|max:255',
            'date' => 'nullable|date|after:today',
            'time' => 'nullable|string|regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $messageData = $validator->validated();

        try {
            // Send email notification
            Mail::to('Info@Rhein-Neckar-Massage.de')->send(new ContactMessage($messageData));

            return response()->json([
                'message' => 'Ihre Nachricht wurde erfolgreich gesendet. Wir werden uns in Kürze bei Ihnen melden.',
                'data' => $messageData
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Contact message email failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Nachricht konnte nicht gesendet werden. Bitte versuchen Sie es später erneut.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
