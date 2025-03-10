<?php

namespace App\Console\Commands;

use App\Services\WeatherServiceProvider\OpenMeteoProvider;
use App\Services\WeatherServiceProvider\WeatherProvider;
use Illuminate\Console\Command;

class OpenMeteoCommand extends Command
{
    protected $signature = 'app:fetch-open-meteo';
    protected $description = 'Get weather data from OpenMeteo';

    /**
     * Execute the console command.
     */
    public function handle(WeatherProvider $weatherProvider)
    {
        dump($weatherProvider->getCurrentWeather());
    }
}
