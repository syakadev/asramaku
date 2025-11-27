<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dormfunds.index');
})->name('home');


use App\Http\Controllers\DormFundController;
use App\Http\Controllers\PerformController;
use App\Http\Controllers\InfractionController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DocumentationActivitiesController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DutyController;
use App\Http\Controllers\DutyScheduleController;
use App\Http\Controllers\LostItemController;

Route::resource('dormfunds', DormFundController::class);
Route::resource('infractions', InfractionController::class);
Route::resource('performs', PerformController::class);
Route::resource('activities', ActivityController::class);
Route::resource('documentations', DocumentationActivitiesController::class);
Route::resource('attendances', AttendanceController::class);
Route::resource('duties', DutyController::class);
Route::resource('dutySchedules', DutyScheduleController::class);
Route::resource('lostitems', LostItemController::class);

Route::get('/documentation/{activity}', [DocumentationActivitiesController::class, 'index'])->name('documentations');

