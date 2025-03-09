<?php

namespace App\Console\Commands;

use App\Services\WeatherDataService\OpenMeteoJsonParser;
use App\Services\WeatherDataService\WeatherApiClient;
use App\Services\WeatherDataService\WeatherDataService;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

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
        try {
            $weatherData = (new WeatherDataService(
                new WeatherApiClient(new Client()),
                new OpenMeteoJsonParser(),
                env('WEATHER_API_URL'),
            ))->getWeatherData();

            Log::info('Погода получена: ' . $weatherData->dateTime->format('Y-m-d H:i:s'));

            dump($weatherData);
        } catch (\Exception $e) {
            Log::error('Ошибка при получении погоды: ' . $e->getMessage());
        }
    }

}
