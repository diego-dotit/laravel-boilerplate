<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::redirect('login', 'admin/login');

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Volt::route('login', 'panel.login')->name('login');

        Route::middleware(['auth', 'canAccessAdmin'])->group(function () {
            Volt::route('/', 'panel.dashboard')->name('dashboard');

            // Users
            Volt::route('users', 'panel.users.index')->name('users');
            Volt::route('user/create', 'panel.users.create')->name('users.create');
            Volt::route('user/{user}/edit', 'panel.users.edit')->name('users.edit');
            Volt::route('user/{user}', 'panel.users.show')->name('users.show');
        });
    });

