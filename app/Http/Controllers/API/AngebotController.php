<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AngebotResource;
use App\Models\Angebot;
use Illuminate\Http\Request;

class AngebotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $page = $request->query('page', 1);

        return AngebotResource::collection(Angebot::paginate($perPage, ['*'], 'page', $page));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'category' => 'required|string|max:255',
            'image' => 'nullable|string',
            'services' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $angebot = Angebot::create($validated);

        return new AngebotResource($angebot);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new AngebotResource(Angebot::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $angebot = Angebot::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'category' => 'required|string|max:255',
            'image' => 'nullable|string',
            'services' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $angebot->update($validated);

        return new AngebotResource($angebot);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $angebot = Angebot::findOrFail($id);
        $angebot->delete();

        return response()->json(['message' => 'Angebot deleted successfully']);
    }
}
