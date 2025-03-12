<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\WeatherServiceProvider\WeatherProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetWeather extends Command
{
    protected $signature = 'app:get-weather';
    protected $description = 'Get weather data from weather API';

    public function __construct(private WeatherProvider $weatherProvider)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $weatherData = $this->weatherProvider->getCurrentWeather();

        Log::info($weatherData);
        dump($weatherData);
    }
}
