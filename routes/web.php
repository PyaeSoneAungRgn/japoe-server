<?php

use App\Livewire\Errors;
use App\Livewire\Projects;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', Projects\Index::class)->name('dashboard');

    Route::get('/projects/{id}', Projects\Show::class)->name('projects.show');

    Route::get('/errors/{id}', Errors\Show::class)->name('errors.show');
});
