<?php

namespace App\Console\Commands;

use App\Services\WeatherDataService\OpenMeteoJsonParser;
use App\Services\WeatherDataService\WeatherDataService;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class WeatherDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from weather API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $weatherData = new WeatherDataService(
            new Client(),
            new OpenMeteoJsonParser(),
            env('WEATHER_API_URL'),
        );

       dump($weatherData->getWeatherData());
    }
}
