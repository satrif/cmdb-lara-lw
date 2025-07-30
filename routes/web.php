<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\CmdbItemList;
use App\Livewire\CmdbItemForm;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

//CMDB ROUTES
Route::get('/cmdb-items', CmdbItemList::class)->name('cmdb-items.index');
Route::get('/cmdb-items/create', CmdbItemForm::class)->name('cmdb-items.create');
Route::get('/cmdb-items/{itemId}/edit', CmdbItemForm::class)->name('cmdb-items.edit');

require __DIR__.'/auth.php';
