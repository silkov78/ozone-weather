<?php

namespace App\Services\WeatherServiceProvider;

use App\Services\WeatherServiceProvider\Enums\WeatherCode;
use App\Services\WeatherServiceProvider\Exceptions\ApiRequestException;
use Illuminate\Support\Facades\Http;

readonly class OpenMeteoProvider implements WeatherProvider
{
    public function __construct(
        public string $apiUrl,
        public array $apiParams
    ) {}

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
            $queryString = http_build_query($this->apiParams);
            $apiEndpoint = $this->apiUrl . '?' . $queryString;

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
