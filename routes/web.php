<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AircraftController;
use Illuminate\Support\Facades\Route;

// Dashboard (homepage)
Route::get('/', DashboardController::class)->name('dashboard');

// Aircraft routes
Route::get('/aircraft/{registration}', [AircraftController::class, 'show'])->name('aircraft.show');
Route::post('/aircraft/{registration}/update-seats', [AircraftController::class, 'updateSeats'])->name('aircraft.updateSeats');

// Fleet Management (CRUD)
Route::resource('fleet', \App\Http\Controllers\FleetController::class);
