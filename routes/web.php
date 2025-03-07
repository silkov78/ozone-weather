<?php

use Illuminate\Support\Facades\Route;
use App\Services\WeatherDataService\WeatherDataService;
use GuzzleHttp\Client;
use App\Services\WeatherDataService\OpenMeteoJsonParser;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/weather', function () {
    $weather = new WeatherDataService(
        new Client(),
        new OpenMeteoJsonParser(),
        env('WEATHER_API_URL'),
        env('WEATHER_API_PARAMS', [])
    );

    $weather->getWeatherData();
});

