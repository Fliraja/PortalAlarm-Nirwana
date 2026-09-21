<?php

use App\Http\Controllers\AlarmApiController;
use Illuminate\Support\Facades\Route;

Route::get('/alarm/{unit}/poll', [AlarmApiController::class, 'poll']);
Route::post('/alarm/{id}/ack', [AlarmApiController::class, 'ack']);
