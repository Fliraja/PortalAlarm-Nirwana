<?php

use App\Http\Controllers\AlarmPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/{unit}', [AlarmPageController::class, 'show'])
    ->whereIn('unit', ['lab', 'radiologi', 'apotek'])
    ->name('alarm.page');
