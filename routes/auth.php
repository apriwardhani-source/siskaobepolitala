<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use Illuminate\Support\Facades\Route;

// Guest routes (belum login)
Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    
    // Google SSO
    Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    Route::get('/auth/google/select-role', [LoginController::class, 'showRoleSelection'])->name('auth.google.select-role');
    Route::post('/auth/google/select-role', [LoginController::class, 'handleRoleSelection'])->name('auth.google.select-role.post');
    
    // Forgot Password
    Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot-password.post');
    Route::get('/validasi-forgot-password/{token}', [LoginController::class, 'validasi_forgotPassword'])->name('validasi-forgot-password');
    Route::get('/reset-password/{token}', [LoginController::class, 'showResetPasswordForm'])->name('reset-password.form');
    Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('reset-password.post');
    
    // Signup
    Route::get('/signup', [SignUpController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [SignUpController::class, 'signup'])->name('signup.post');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Profile
    Route::get('/settings/profile', [\App\Http\Controllers\SettingsController::class, 'profile'])->name('settings.profile');
    Route::put('/settings/profile', [\App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.update-profile');
    Route::put('/settings/password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.update-password');
});
