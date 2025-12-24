<?php

use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;

Route::apiResource('cities', CityController::class);

