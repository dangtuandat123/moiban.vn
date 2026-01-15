<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// INTERNAL API (Protected by secret token)
// =========================================================================

Route::middleware(['internal.api'])->prefix('internal')->group(function () {
    // Webhook nạp tiền từ hệ thống bên ngoài (ACB.py)
    Route::post('/wallet/deposit', [\App\Http\Controllers\Api\InternalWalletController::class, 'deposit']);
});

// =========================================================================
// PUBLIC API
// =========================================================================

Route::prefix('v1')->group(function () {
    // Lấy thông tin thiệp (cho OG image generator)
    Route::get('/invitations/{slug}', [\App\Http\Controllers\Api\InvitationApiController::class, 'show']);
});
