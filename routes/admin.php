<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\MovieUpload;

Route::get('/admin/movies/upload', MovieUpload::class)->name('admin.movies.upload');
