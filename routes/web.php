<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Dashboard route (protected)
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// Settings routes (protected)
Route::get('/settings', [HomeController::class, 'settings'])->middleware('auth')->name('settings');
Route::post('/settings/change-password', [HomeController::class, 'changePassword'])->middleware('auth')->name('settings.change-password');
Route::delete('/settings/delete-account', [HomeController::class, 'deleteAccount'])->middleware('auth')->name('settings.delete-account');
