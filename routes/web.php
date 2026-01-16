<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Hệ thống thiệp cưới online - moiban.vn
|
*/

// =========================================================================
// PUBLIC ROUTES (Guest)
// =========================================================================

Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');
Route::get('/templates', [\App\Http\Controllers\Public\HomeController::class, 'templates'])->name('templates');
Route::get('/pricing', [\App\Http\Controllers\Public\HomeController::class, 'pricing'])->name('pricing');

// =========================================================================
// AUTH ROUTES
// =========================================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
});

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware('auth');

// =========================================================================
// USER ROUTES (Authenticated)
// =========================================================================

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

    // Invitations CRUD
    Route::resource('invitations', \App\Http\Controllers\User\InvitationController::class);

    // Invitation Editor
    Route::get('/invitations/{invitation}/editor', [\App\Http\Controllers\User\EditorController::class, 'index'])->name('invitations.editor');
    Route::post('/invitations/{invitation}/editor', [\App\Http\Controllers\User\EditorController::class, 'save'])->name('invitations.editor.save');

    // Wallet
    Route::get('/wallet', [\App\Http\Controllers\User\WalletController::class, 'index'])->name('wallet');
    Route::get('/wallet/deposit', [\App\Http\Controllers\User\WalletController::class, 'deposit'])->name('wallet.deposit');

    // Purchase/Activate invitation
    Route::get('/invitations/{invitation}/purchase', [\App\Http\Controllers\User\PurchaseController::class, 'index'])->name('invitations.purchase');
    Route::post('/invitations/{invitation}/purchase', [\App\Http\Controllers\User\PurchaseController::class, 'process'])->name('invitations.purchase.process');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\User\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\User\ProfileController::class, 'updatePassword'])->name('profile.password');
});

// =========================================================================
// ADMIN ROUTES
// =========================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // User Management (chỉ index, show, destroy)
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'show', 'destroy']);

    // Invitation Management (chỉ index, show, destroy)
    Route::resource('invitations', \App\Http\Controllers\Admin\InvitationController::class)->only(['index', 'show', 'destroy']);
    Route::post('/invitations/{invitation}/lock', [\App\Http\Controllers\Admin\InvitationController::class, 'lock'])->name('invitations.lock');
    Route::post('/invitations/{invitation}/unlock', [\App\Http\Controllers\Admin\InvitationController::class, 'unlock'])->name('invitations.unlock');

    // Template Management
    Route::resource('templates', \App\Http\Controllers\Admin\TemplateController::class);
    Route::post('/templates/upload', [\App\Http\Controllers\Admin\TemplateController::class, 'upload'])->name('templates.upload');

    // Package Management
    Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class);

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});

// =========================================================================
// PUBLIC INVITATION VIEW (moiban.vn/{slug})
// =========================================================================

// OG Image cho Social Sharing
Route::get('/og-image/{slug}', [\App\Http\Controllers\OgImageController::class, 'show'])->name('og-image');
Route::get('/og-image/{slug}/png', [\App\Http\Controllers\OgImageController::class, 'generatePng'])->name('og-image.png');

// Trang thiệp bị khóa
Route::get('/locked/{slug}', [\App\Http\Controllers\Public\InvitationController::class, 'locked'])->name('invitation.locked');
Route::get('/expired/{slug}', [\App\Http\Controllers\Public\InvitationController::class, 'expired'])->name('invitation.expired');

// RSVP submission
Route::post('/{slug}/rsvp', [\App\Http\Controllers\Public\RsvpController::class, 'store'])->name('invitation.rsvp.store');

// Guestbook submission
Route::post('/{slug}/guestbook', [\App\Http\Controllers\Public\GuestbookController::class, 'store'])->name('invitation.guestbook.store');

// View invitation (PHẢI ĐỂ CUỐI CÙNG vì catch-all slug)
Route::get('/{slug}', [\App\Http\Controllers\Public\InvitationController::class, 'show'])
    ->name('invitation.show')
    ->middleware('check.invitation');
