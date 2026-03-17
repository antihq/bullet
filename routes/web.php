<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('dashboard', 'notes')->name('dashboard');
    Route::livewire('notes', 'pages::notes.index')->name('notes.index');
});

require __DIR__.'/settings.php';
