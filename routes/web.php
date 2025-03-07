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
        "https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&current=temperature_2m,weather_code,cloud_cover",
    );

    $weather->getWeatherData();
});

