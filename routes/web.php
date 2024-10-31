<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {

    Route::group([
        'as' => 'doctor.',
        'middleware' => 'is_doctor',
    ], function () {
        Route::get('/appointment', [App\Http\Controllers\Doctor\AppointmentController::class, 'index'])
            ->name('appointment.index');
    });

//    Route::group([
//        'as' => 'patient.',
//    ], function () {
//        Route::get('/appointment', [App\Http\Controllers\Patient\AppointmentController::class, 'index'])
//            ->name('appointment.index');
//    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
