<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::redirect('login', 'admin/login');

Route::middleware(['auth'])->get('logout', Logout::class)->name('logout');


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
            Volt::route('user/{user}', 'admin.users.show')->name('users.show');
        });
    });

// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
//     Volt::route('settings/password', 'settings.password')->name('password.edit');
//     Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

//     Volt::route('settings/two-factor', 'settings.two-factor')
//         ->middleware(
//             when(
//                 Features::canManageTwoFactorAuthentication()
//                     && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
//                 ['password.confirm'],
//                 [],
//             ),
//         )
//         ->name('two-factor.show');
// });
