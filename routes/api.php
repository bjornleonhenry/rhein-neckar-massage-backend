<?php

use App\Http\Controllers\API\AngebotController;
use App\Http\Resources\AngebotResource;
use App\Http\Resources\MieterinResource;
use App\Http\Resources\GaestebuchResource;
use App\Http\Resources\ProfileResource;
use App\Models\Mieterin;
use App\Models\Gaestebuch;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user() ? new UserResource($request->user()) : [];
});

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::get('/users', function (Request $request) {
    $perPage = $request->query('per_page', 15);
    $page = $request->query('page', 1);

    return UserResource::collection(User::paginate($perPage, ['*'], 'page', $page));
});

Route::get('/gaestebuchs', function (Request $request) {
    $perPage = $request->query('per_page', 15);
    $page = $request->query('page', 1);

    return GaestebuchResource::collection(Gaestebuch::paginate($perPage, ['*'], 'page', $page));
});

Route::get('/gaestebuchs/{id}', function ($id) {
    return new GaestebuchResource(Gaestebuch::findOrFail($id));
});

Route::post('/gaestebuchs', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'date' => 'required|date',
        'rating' => 'required|integer|min:1|max:5',
        'service' => 'required|string|max:255',
        'message' => 'required|string',
        'verified' => 'boolean',
    ]);

    $gaestebuch = Gaestebuch::create($validated);

    return new GaestebuchResource($gaestebuch);
});

Route::put('/gaestebuchs/{id}', function (Request $request, $id) {
    $gaestebuch = Gaestebuch::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'date' => 'required|date',
        'rating' => 'required|integer|min:1|max:5',
        'service' => 'required|string|max:255',
        'message' => 'required|string',
        'verified' => 'boolean',
    ]);

    $gaestebuch->update($validated);

    return new GaestebuchResource($gaestebuch);
});

Route::delete('/gaestebuchs/{id}', function ($id) {
    $gaestebuch = Gaestebuch::findOrFail($id);
    $gaestebuch->delete();

    return response()->json(['message' => 'Gaestebuch deleted successfully']);
});

Route::apiResource('/angebots', AngebotController::class);

Route::get('/mieterinnen', function (Request $request) {
    $perPage = $request->query('per_page', 15);
    $page = $request->query('page', 1);

    return MieterinResource::collection(Mieterin::paginate($perPage, ['*'], 'page', $page));
});

Route::get('/mieterinnen/{id}', function ($id) {
    // Try to find by ID first, then by name if ID is not numeric
    if (is_numeric($id)) {
        $mieterin = Mieterin::find($id);
    } else {
        $mieterin = Mieterin::where('name', urldecode($id))->first();
    }

    if (!$mieterin) {
        return response()->json(['error' => 'Mieterin not found'], 404);
    }

    return new MieterinResource($mieterin);
});

Route::post('/mieterinnen', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'age' => 'required|integer|min:18|max:100',
        'description' => 'required|string',
        'image' => 'required|string',
        'specialties' => 'required|array',
        'languages' => 'required|array',
        'working_hours' => 'required|string',
        'rating' => 'required|numeric|min:0|max:5',
    ]);

    $mieterin = Mieterin::create($validated);

    return new MieterinResource($mieterin);
});

Route::put('/mieterinnen/{id}', function (Request $request, $id) {
    $mieterin = Mieterin::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'age' => 'required|integer|min:18|max:100',
        'description' => 'required|string',
        'image' => 'required|string',
        'specialties' => 'required|array',
        'languages' => 'required|array',
        'working_hours' => 'required|string',
        'rating' => 'required|numeric|min:0|max:5',
    ]);

    $mieterin->update($validated);

    return new MieterinResource($mieterin);
});

Route::delete('/mieterinnen/{id}', function ($id) {
    $mieterin = Mieterin::findOrFail($id);
    $mieterin->delete();

    return response()->json(['message' => 'Mieterin deleted successfully']);
});

Route::get('/GirlsProfiles', function (Request $request) {
    $perPage = $request->query('per_page', 15);
    $page = $request->query('page', 1);

    return MieterinResource::collection(Mieterin::paginate($perPage, ['*'], 'page', $page));
});

Route::get('/GirlsProfiles/{id}', function ($id) {
    // Try to find by ID first, then by name if ID is not numeric
    if (is_numeric($id)) {
        $mieterin = Mieterin::find($id);
    } else {
        $mieterin = Mieterin::where('name', urldecode($id))->first();
    }

    if (!$mieterin) {
        return response()->json(['error' => 'Mieterin not found'], 404);
    }

    return new MieterinResource($mieterin);
});

// Language Strings API
Route::get('/language-strings', function (Request $request) {
    $lang = $request->query('lang', 'en'); // Default to English if no lang specified
    $languageKeys = \App\Models\LanguageKey::where('is_active', true)
        ->with(['translations' => function ($q) use ($lang) {
            $q->whereIn('lang', ['en', 'de'])->where('is_active', true);
        }])
        ->get()
        ->map(function ($key) use ($lang) {
            $en = $key->translations->first(fn($t) => $t->lang === 'en');
            $de = $key->translations->first(fn($t) => $t->lang === 'de');

            return [
                'key' => $key->key,
                'type' => $key->type,
                'german' => $de ? $de->value : $key->default,
                'english' => $en ? $en->value : $key->default,
                'default' => $key->default,
                'tags' => $key->tags ?? [],
            ];
        });

    // compute last updated timestamp across keys and translations
    $lastUpdatedKey = \App\Models\LanguageKey::where('is_active', true)->max('updated_at');
    $lastUpdatedTranslation = \App\Models\LanguageString::where('is_active', true)->max('updated_at');
    $lastUpdated = collect([$lastUpdatedKey, $lastUpdatedTranslation])->filter()->max();

    if ($lastUpdated instanceof \DateTimeInterface) {
        $lastUpdatedStr = $lastUpdated->format('Y-m-d H:i:s');
    } else {
        $lastUpdatedStr = $lastUpdated ? (string) $lastUpdated : null;
    }

    return response()->json([
        'data' => $languageKeys,
        'last_updated' => $lastUpdatedStr,
    ]);
});

// Bulk update translations from frontend
Route::post('/language-strings/bulk-update', function (Request $request) {
    $payload = $request->validate([
        'translations' => 'required|array',
        'translations.*.key' => 'required|string',
        'translations.*.english' => 'nullable|string',
        'translations.*.german' => 'nullable|string',
    ]);

    $updated = 0;

    foreach ($payload['translations'] as $item) {
        $key = \App\Models\LanguageKey::where('key', $item['key'])->first();
        if (!$key) {
            // skip unknown keys
            continue;
        }

        if (array_key_exists('english', $item) && $item['english'] !== null) {
            $en = $key->translations()->firstOrNew(['lang' => 'en']);
            $en->value = $item['english'];
            $en->is_active = true;
            $key->translations()->save($en);
            $updated++;
        }

        if (array_key_exists('german', $item) && $item['german'] !== null) {
            $de = $key->translations()->firstOrNew(['lang' => 'de']);
            $de->value = $item['german'];
            $de->is_active = true;
            $key->translations()->save($de);
            $updated++;
        }
    }

    // Return latest last_updated timestamp for frontend cache
    $lastUpdatedKey = \App\Models\LanguageKey::where('is_active', true)->max('updated_at');
    $lastUpdatedTranslation = \App\Models\LanguageString::where('is_active', true)->max('updated_at');
    $lastUpdated = collect([$lastUpdatedKey, $lastUpdatedTranslation])->filter()->max();

    if ($lastUpdated instanceof \DateTimeInterface) {
        $lastUpdatedStr = $lastUpdated->format('Y-m-d H:i:s');
    } else {
        $lastUpdatedStr = $lastUpdated ? (string) $lastUpdated : null;
    }

    return response()->json([
        'updated' => $updated,
        'last_updated' => $lastUpdatedStr,
    ]);
});

// Simple frontend-friendly language endpoint
Route::get('/language', function (Request $request) {
    $lang = $request->query('lang', 'en');

    $languageKeys = \App\Models\LanguageKey::where('is_active', true)
        ->with(['translations' => function ($q) use ($lang) {
            $q->where('lang', $lang)->where('is_active', true);
        }])
        ->get();

    // produce flat map key => value (fallback to default)
    $map = $languageKeys->mapWithKeys(function ($key) use ($lang) {
        $translation = $key->translations->first();
        $value = $translation ? $translation->value : $key->default;
        return [$key->key => $value];
    });

    // compute last updated timestamp across keys and translations
    $lastUpdatedKey = \App\Models\LanguageKey::where('is_active', true)->max('updated_at');
    $lastUpdatedTranslation = \App\Models\LanguageString::where('is_active', true)->max('updated_at');
    $lastUpdated = collect([$lastUpdatedKey, $lastUpdatedTranslation])->filter()->max();

    if ($lastUpdated instanceof \DateTimeInterface) {
        $lastUpdatedStr = $lastUpdated->format('Y-m-d H:i:s');
    } else {
        $lastUpdatedStr = $lastUpdated ? (string) $lastUpdated : null;
    }

    return response()->json([
        'data' => $map,
        'last_updated' => $lastUpdatedStr,
    ]);
});

// Profiles API
Route::get('/profiles', function (Request $request) {
    $perPage = $request->query('per_page', 15);
    $page = $request->query('page', 1);

    return ProfileResource::collection(Profile::where('active', true)->paginate($perPage, ['*'], 'page', $page));
});

Route::get('/profiles/{id}', function ($id) {
    try {
        // Try to find by ID first (numeric)
        if (is_numeric($id)) {
            $profile = Profile::findOrFail($id);
        } else {
            // If not numeric, try to find by name
            $profile = Profile::where('name', $id)->firstOrFail();
        }
        return new ProfileResource($profile);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Profile not found', 'message' => $e->getMessage()], 404);
    }
});
