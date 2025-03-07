<?php

namespace App\Services\WeatherDataService\Interfaces;

use App\Services\WeatherDataService\WeatherData;

interface WeatherJsonParserInterface
{
    public function parseData(string $jsonString): WeatherData;
}
