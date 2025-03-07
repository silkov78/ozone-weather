<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/weather', function () {
    $weather = new App\Services\WeatherDataService\WeatherDataService(
        new \GuzzleHttp\Client(),
        "https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&current=temperature_2m,weather_code,cloud_cover",
    );

    $weather->getWeatherData();
});

