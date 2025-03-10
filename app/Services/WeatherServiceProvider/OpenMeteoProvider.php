<?php

namespace App\Services\WeatherServiceProvider;

use App\Services\WeatherServiceProvider\Enums\WeatherCode;
use App\Services\WeatherServiceProvider\Exceptions\ApiRequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

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
        $response = HTTP::get(
            self::OPEN_METEO_URL,
            self::OPEN_METEO_QUERY_PARAMS
        );

        return $this->validateResponse($response);
    }

    private function validateResponse(Response $response): WeatherData
    {
        if (! $response->successful()) {
            throw new ApiRequestException(
                'Данные с API не были получены. Статус ответа: ' . $response->getStatusCode()
            );
        }

        $validWeatherCodes = array_column(WeatherCode::cases(), 'value');
        $rules = [
            'current.time' => 'required|date_format:Y-m-d\TH:i',
            'current.interval' => 'required|integer',
            'current.temperature_2m' => 'required|numeric',
            'current.cloud_cover' => 'required|numeric:gte:0',
            'current.weather_code' => [
                'required',
                'integer',
                'in:' . implode(',', $validWeatherCodes),
            ],
        ];

        $data = $response->json();

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ApiRequestException(
                'Невалидные данные: ' . $validator->errors()
            );
        }

        return $this->createWeatherDataObject($data);
    }

    private function createWeatherDataObject(array $data): WeatherData
    {
        return new WeatherData(
            new \DateTime($data['current']['time']),
            $data['current']['temperature_2m'],
            $data['current']['cloud_cover'],
            WeatherCode::fromCode($data['current']['weather_code']),
        );
    }
}
