<?php

use App\Http\Controllers\CurrentWeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/weather', [CurrentWeatherController::class, 'getCurrentWeather']);
