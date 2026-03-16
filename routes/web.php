<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::dashboard')->name('dashboard');
    Route::livewire('boards', 'pages::boards.index')->name('boards.index');
    Route::livewire('boards/create', 'pages::boards.create')->name('boards.create');
    Route::livewire('boards/{board}', 'pages::boards.show')->name('boards.show');
});

require __DIR__.'/settings.php';
