<?php

namespace App\Console\Commands;

use App\Services\WeatherServiceProvider\OpenMeteoProvider;
use App\Services\WeatherServiceProvider\WeatherProvider;
use Illuminate\Console\Command;

class GetWeather extends Command
{
    protected $signature = 'app:get-weather';
    protected $description = 'Get weather data from weather API';

    public function handle(WeatherProvider $weatherProvider)
    {
        dump($weatherProvider->getCurrentWeather());
    }
}
