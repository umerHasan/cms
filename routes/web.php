<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Explicit root route -> always serve the "home" page
Route::get('/', [PageController::class, 'home'])->name('home');

// Catch-all page route (MUST BE LAST)
Route::get('/{path?}', [PageController::class, 'show'])
    ->where('path', '.*')
    ->name('page.show');
