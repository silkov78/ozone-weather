<?php

namespace App\Services\WeatherServiceProvider;

use App\Services\WeatherServiceProvider\Enums\WeatherCode;
use App\Services\WeatherServiceProvider\Exceptions\ApiRequestException;
use Illuminate\Support\Facades\Http;

readonly class OpenMeteoProvider implements WeatherProvider
{
    private const OPEN_METEO_URL = 'https://api.open-meteo.com/v1/forecast';
    private const OPEN_METEO_QUERY_PARAMS = [
        'latitude' => 53.8978,
        'longitude' => 27.5563,
        'current' => 'temperature_2m,weather_code,cloud_cover'
    ];

    public function getCurrentWeather(): WeatherData
    {
        $jsonString = $this->getJsonStringFromApi();
        $dataArray = json_decode($jsonString,true)["current"];

        return new WeatherData(
            new \DateTime($dataArray['time']),
            $dataArray['temperature_2m'],
            $dataArray['cloud_cover'],
            WeatherCode::fromCode($dataArray['weather_code']),
        );

    }

    private function getJsonStringFromApi(): string
    {
        try {
            $queryString = http_build_query(self::OPEN_METEO_QUERY_PARAMS);
            $apiEndpoint = self::OPEN_METEO_URL . '?' . $queryString;

            $response = HTTP::get($apiEndpoint);
        } catch (\Exception $e) {
            throw new ApiRequestException($e->getMessage());
        }

        if ($response->successful()) {
            return $response->getBody()->getContents();
        }

        throw new ApiRequestException(
            'Данные о погоде не были получены. Статус ответа: ' . $response->getStatusCode()
        );
    }

}
