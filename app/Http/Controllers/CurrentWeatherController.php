<?php

namespace App\Http\Controllers;

use App\Services\WeatherDataService\OpenMeteoJsonParser;
use App\Services\WeatherDataService\WeatherData;
use App\Services\WeatherDataService\WeatherDataService;
use GuzzleHttp\Client;

class CurrentWeatherController
{
    public function getCurrentWeather(): void
    {
       $weatherData = new WeatherDataService(
            new Client(),
            new OpenMeteoJsonParser(),
            env('WEATHER_API_URL'),
        );

       dump($weatherData->getWeatherData());
    }
}
