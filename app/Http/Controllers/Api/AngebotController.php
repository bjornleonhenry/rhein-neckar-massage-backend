<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AngebotResource;
use App\Models\Angebot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

class AngebotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        $page = $request->query('page', 1);
        $category = $request->query('category');
        
        // Default to showing only active angebots
        $activeOnlyParam = $request->query('active_only');
        $activeOnly = $activeOnlyParam === null ? true : filter_var($activeOnlyParam, FILTER_VALIDATE_BOOLEAN);

        $query = Angebot::query()
            ->with('options')
            ->select(['id', 'title', 'description', 'price', 'duration_minutes', 'category', 'image', 'services', 'is_active', 'created_at', 'updated_at']);

        if ($category) {
            $query->where('category', $category);
        }

        // Filter by active status
        if ($activeOnly) {
            $query->where('is_active', 1);
        }

        $query->orderBy('is_active', 'desc')
              ->orderBy('created_at', 'desc');

        $angebots = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => AngebotResource::collection($angebots->items()),
            'meta' => [
                'current_page' => $angebots->currentPage(),
                'last_page' => $angebots->lastPage(),
                'per_page' => $angebots->perPage(),
                'total' => $angebots->total(),
            ],
            'links' => [
                'first' => $angebots->url(1),
                'last' => $angebots->url($angebots->lastPage()),
                'prev' => $angebots->previousPageUrl(),
                'next' => $angebots->nextPageUrl(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
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

        // Clear cache after creating new angebot
        Cache::flush();

        return response()->json([
            'data' => new AngebotResource($angebot),
            'message' => 'Angebot created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $cacheKey = "angebot_{$id}";

        $angebot = Cache::remember($cacheKey, 3600, function () use ($id) {
            return Angebot::select(['id', 'title', 'description', 'price', 'duration_minutes', 'category', 'image', 'services', 'is_active', 'created_at', 'updated_at'])
                ->findOrFail($id);
        });

        return response()->json([
            'data' => new AngebotResource($angebot)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
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

        // Clear cache after updating
        Cache::flush();

        return response()->json([
            'data' => new AngebotResource($angebot),
            'message' => 'Angebot updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $angebot = Angebot::findOrFail($id);
        $angebot->delete();

        // Clear cache after deleting
        Cache::flush();

        return response()->json([
            'message' => 'Angebot deleted successfully'
        ]);
    }
}
