<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AmbientResource;
use App\Models\Ambient;
use Illuminate\Http\Request;

class AmbientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $page = $request->query('page', 1);

        return AmbientResource::collection(
            Ambient::where('is_active', true)
                ->paginate($perPage, ['*'], 'page', $page)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'size' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'amenities' => 'nullable|array',
            'image' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_active' => 'boolean',
        ]);

        $ambient = Ambient::create($validated);

        return new AmbientResource($ambient);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ambient = Ambient::where('is_active', true)->findOrFail($id);
        return new AmbientResource($ambient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ambient = Ambient::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'size' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'amenities' => 'nullable|array',
            'image' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_active' => 'boolean',
        ]);

        $ambient->update($validated);

        return new AmbientResource($ambient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ambient = Ambient::findOrFail($id);
        $ambient->delete();

        return response()->json(['message' => 'Ambient deleted successfully']);
    }
}
