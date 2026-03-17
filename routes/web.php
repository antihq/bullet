<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('dashboard', 'notes');
    Route::livewire('notes', 'pages::notes.index')->name('dashboard');
});

require __DIR__.'/settings.php';
