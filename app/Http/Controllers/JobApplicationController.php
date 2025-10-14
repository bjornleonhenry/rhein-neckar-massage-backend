<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'age' => 'required|integer|min:21|max:100',
            'nationality' => 'required|string|max:255',
            'languages' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'experience' => 'nullable|in:keine,wenig,mittel,viel',
            'availability' => 'nullable|in:vollzeit,teilzeit,wochenende,flexibel',
            'specialties' => 'nullable|array',
            'specialties.*' => 'string',
            'motivation' => 'required|string',
            'references' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $jobApplication = JobApplication::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'age' => $request->age,
            'nationality' => $request->nationality,
            'languages' => $request->languages,
            'email' => $request->email,
            'phone' => $request->phone,
            'experience' => $request->experience,
            'availability' => $request->availability,
            'specialties' => $request->specialties ?? [],
            'motivation' => $request->motivation,
            'references' => $request->references,
            'status' => 'pending',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vielen Dank für Ihre Bewerbung! Wir werden uns in Kürze bei Ihnen melden.',
            'data' => $jobApplication
        ], 201);
    }
}
