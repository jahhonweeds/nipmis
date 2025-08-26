<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Municipality\Municipalities;
use App\Livewire\School\Schools;
use App\Livewire\Vaccines\VaccinesList;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/vaccines', VaccinesList::class)->name('vaccines');
    Route::get('/municipalities', Municipalities::class)->name('municipalities');
    Route::get('/schools', Schools::class)->name('schools');
    Route::get('/vaccinetransactions', \App\Livewire\Vaccines\VaccineTransactionsList::class)->name('vaccinetransactions');
    Route::get('/usermanagement', \App\Livewire\UsersManagement::class)->name('usermanagement');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});



require __DIR__ . '/auth.php';
