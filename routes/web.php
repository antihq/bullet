<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect(Auth::check() ? 'dashboard' : 'home'));
Route::livewire('/home', 'pages::home')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('dashboard', 'notes')->name('dashboard');
    Route::livewire('notes', 'pages::notes.index')->name('notes.index');
});

require __DIR__.'/settings.php';
