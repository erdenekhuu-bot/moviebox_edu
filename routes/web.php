<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Dashboard\MovieCategoryController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth','verified'])->prefix('dashboard')->group(function () {
    Route::view('','dashboard')->name('dashboard');
    Route::view('category','components.Movies.category')->name('category');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
require __DIR__.'/trends.php';
require __DIR__.'/movies.php';
require __DIR__.'/series.php';
require __DIR__.'/collection.php';
