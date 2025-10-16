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
        Volt::route('login', 'admin.login')->name('login');

        Route::middleware(['auth', 'canAccessAdmin'])->group(function () {
            Volt::route('/', 'admin.dashboard')->name('dashboard');

            // Users
            Volt::route('users', 'admin.users.index')->name('users');
            Volt::route('user/create', 'admin.users.form')->name('users.create');
            Volt::route('user/{user}/edit', 'admin.users.form')->name('users.edit');
            // Volt::route('user/{user}', 'admin.users.show')->name('users.show');
        });
    });

