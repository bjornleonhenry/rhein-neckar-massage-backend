<?php

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Resources\AngebotResource;
use App\Models\Angebot;
use App\Http\Resources\AmbientResource;
use App\Models\Ambient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('api/user', function (Request $request) {
    return $request->user() ? new UserResource($request->user()) : [];
});

Route::get('api/health', function () {
    return response()->json(['status' => 'ok']);
});

// Dev-only: send a test database notification to the given user id (GET)
Route::get('dev/notify/{id}', function ($id) {
    $user = App\Models\User::find($id);

    if (! $user) {
        return response()->json(['error' => 'user not found'], 404);
    }

    $user->notify(new App\Notifications\GeneralNotification(
        'Test notification',
        'This is a test notification sent from dev route',
        'heroicon-o-bell',
        'primary',
        '/admin',
        'Open'
    ));

    return response()->json(['ok' => true]);
});

Route::get('api/users', function (Request $request) {
    $perPage = $request->query('per_page', 15);
    $page = $request->query('page', 1);

    return UserResource::collection(User::paginate($perPage, ['*'], 'page', $page));
});

Route::post('api/users', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    return new UserResource($user);
});

Route::get('api/users/{id}', function ($id) {
    return new UserResource(User::findOrFail($id));
});

Route::get('api/angebots', function (Request $request) {
    $perPage = $request->query('per_page', 15);
    $page = $request->query('page', 1);

    return AngebotResource::collection(Angebot::paginate($perPage, ['*'], 'page', $page));
});

Route::get('api/angebots/{id}', function ($id) {
    return new AngebotResource(Angebot::findOrFail($id));
});

Route::post('api/angebots', function (Request $request) {
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
});

Route::put('api/angebots/{id}', function (Request $request, $id) {
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
});

Route::delete('api/angebots/{id}', function ($id) {
    $angebot = Angebot::findOrFail($id);
    $angebot->delete();

    return response()->json(['message' => 'Angebot deleted successfully']);
});

Route::get('api/ambients', function (Request $request) {
    $perPage = $request->query('per_page', 15);
    $page = $request->query('page', 1);

    return AmbientResource::collection(Ambient::paginate($perPage, ['*'], 'page', $page));
});

Route::get('api/ambients/{id}', function ($id) {
    return new AmbientResource(Ambient::findOrFail($id));
});

Route::post('api/ambients', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1',
        'features' => 'required|array',
        'amenities' => 'required|array',
        'image' => 'nullable|string',
        'rating' => 'numeric|min:0|max:5',
        'is_active' => 'boolean',
    ]);

    $ambient = Ambient::create($validated);

    return new AmbientResource($ambient);
});

Route::put('api/ambients/{id}', function (Request $request, $id) {
    $ambient = Ambient::findOrFail($id);
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1',
        'features' => 'required|array',
        'amenities' => 'required|array',
        'image' => 'nullable|string',
        'rating' => 'numeric|min:0|max:5',
        'is_active' => 'boolean',
    ]);

    $ambient->update($validated);

    return new AmbientResource($ambient);
});

Route::delete('api/ambients/{id}', function ($id) {
    $ambient = Ambient::findOrFail($id);
    $ambient->delete();

    return response()->json(['message' => 'Ambient deleted successfully']);
});

Route::get('reset-password/{token}', function ($token, Request $request) {
    return redirect(frontendUrl("auth/reset-password/{$token}?email=" . $request->get('email')));
})->name('password.reset');

// Message routes
use App\Http\Controllers\MessageController;
Route::post('/api/messages', [MessageController::class, 'store']);

// Job application routes
use App\Http\Controllers\JobApplicationController;
Route::post('/api/job-applications', [JobApplicationController::class, 'store']);

// Booking routes
use App\Http\Controllers\BookingController;
Route::post('/api/bookings', [BookingController::class, 'store']);
