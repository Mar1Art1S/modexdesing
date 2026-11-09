<?php

use Illuminate\Support\Facades\Route;

// Unified Single-Page Marketing & Engineering Platform
Route::view('/', 'welcome')->name('home');
Route::view('projects', 'welcome')->name('projects');
Route::view('3d-printing', 'welcome')->name('printing');
Route::view('engineering', 'welcome')->name('engineering');
Route::view('contacts', 'welcome')->name('contacts');

// Animation Test Page (interactive line drawings from xplore.ai)
Route::view('test-animation', 'test-animation')->name('test-animation');

// Authenticated Client Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
