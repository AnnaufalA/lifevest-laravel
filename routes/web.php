<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AircraftController;
use Illuminate\Support\Facades\Route;

// Dashboard (homepage)
Route::get('/', DashboardController::class)->name('dashboard');

// Aircraft routes
Route::get('/aircraft/{registration}', [AircraftController::class, 'show'])->name('aircraft.show');
Route::post('/aircraft/{registration}/update-seats', [AircraftController::class, 'updateSeats'])->name('aircraft.updateSeats');
Route::delete('/aircraft/{registration}/delete-seat', [AircraftController::class, 'deleteSeat'])->name('aircraft.deleteSeat');

// Fleet Management (CRUD)
Route::resource('fleet', \App\Http\Controllers\FleetController::class);

// Airlines Management (under fleet)
Route::get('/fleet/airlines/create', [\App\Http\Controllers\FleetController::class, 'createAirline'])->name('airlines.create');
Route::post('/fleet/airlines', [\App\Http\Controllers\FleetController::class, 'storeAirline'])->name('airlines.store');
Route::get('/fleet/airlines/{id}/edit', [\App\Http\Controllers\FleetController::class, 'editAirline'])->name('airlines.edit');
Route::put('/fleet/airlines/{id}', [\App\Http\Controllers\FleetController::class, 'updateAirline'])->name('airlines.update');
Route::delete('/fleet/airlines/{id}', [\App\Http\Controllers\FleetController::class, 'destroyAirline'])->name('airlines.destroy');
