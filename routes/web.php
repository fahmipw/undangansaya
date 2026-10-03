<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LegacyApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Admin Panel Routes (Matching Old URLs) ---
Route::get('login.php', [AdminController::class, 'showLogin'])->name('login');
Route::post('login.php', [AdminController::class, 'login']);
Route::get('logout.php', [AdminController::class, 'logout']);

Route::middleware('auth:admin')->group(function () {
    Route::get('admin.php', [AdminController::class, 'index']);
    
    // Legacy Admin API
    Route::any('api/admin_api.php', [LegacyApiController::class, 'adminApi'])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
});

// --- Legacy Frontend APIs ---
Route::any('api/rsvp.php', [ApiController::class, 'rsvp'])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
Route::any('api/ucapan.php', [ApiController::class, 'ucapan'])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
Route::any('api/music.php', [ApiController::class, 'music']);
Route::any('api/get_settings.php', [ApiController::class, 'getSettings']);

// --- Generator Route ---
Route::get('/generator/{slug}', [FrontController::class, 'generator']);
Route::post('api/generate_guest', [ApiController::class, 'generateGuest'])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

// --- Frontend Routes ---
Route::get('/', [FrontController::class, 'index']);
Route::get('/{slug}', [FrontController::class, 'index']);
