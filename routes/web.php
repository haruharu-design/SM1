<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodanaController;

Route::get('/', [TodanaController::class, 'index'])->name('home');