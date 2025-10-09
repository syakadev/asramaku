<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DormFundController;
use App\Http\Controllers\PerformController;
use App\Http\Controllers\InfractionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AttendanceController;

Route::resource('dormfunds', DormFundController::class);
Route::resource('infractions', InfractionController::class);
Route::resource('performs', PerformController::class);
Route::resource('activities', ActivityController::class);
Route::resource('attendances', AttendanceController::class);
