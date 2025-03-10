<?php

namespace App\Console\Commands;

use App\Services\WeatherServiceProvider\OpenMeteoProvider;
use Illuminate\Console\Command;

class OpenMeteoCommand extends Command
{
    protected $signature = 'app:fetch-open-meteo';
    protected $description = 'Get weather data from OpenMeteo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = env('WEATHER_API_URL');
        $params = [
            'latitude' => 53.8978,
            'longitude' => 27.5563,
            'current' => 'temperature_2m,weather_code,cloud_cover'
        ];

        $weatherData = new OpenMeteoProvider($url, $params);

        dump($weatherData->getCurrentWeather());
    }
}
