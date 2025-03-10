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
        try {
            $queryString = http_build_query($this->apiParams);
            $apiEndpoint = $this->apiUrl . '?' . $queryString;

            $response = HTTP::get($apiEndpoint);

            if ($response->successful()) {
                $dataArray = json_decode($response->getBody()->getContents(), true)["current"];

                return new WeatherData(
                    new \DateTime($dataArray['time']),
                    $dataArray['temperature_2m'],
                    $dataArray['cloud_cover'],
                    WeatherCode::fromCode($dataArray['weather_code']),
                );
            }
        } catch (\Exception $e) {
            throw new ApiRequestException($e->getMessage());
        }
    }

}
