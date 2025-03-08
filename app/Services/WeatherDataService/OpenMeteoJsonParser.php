<?php

declare(strict_types=1);

namespace App\Services\WeatherDataService;

use App\Services\WeatherDataService\Enums\WeatherCode;
use App\Services\WeatherDataService\Interfaces\WeatherJsonParserInterface;

class OpenMeteoJsonParser implements WeatherJsonParserInterface
{
    public function parseData(string $jsonString): WeatherData
    {
        $weatherArray = json_decode($jsonString, true)['current'];

        // ??? Наверное нужна валидация этого json-a
        $weatherData = new WeatherData(
            new \DateTime($weatherArray['time']),
            $weatherArray['temperature_2m'],
            $weatherArray['cloud_cover'],
            WeatherCode::fromCode($weatherArray['weather_code']),
        );

        return $weatherData;
    }
}
