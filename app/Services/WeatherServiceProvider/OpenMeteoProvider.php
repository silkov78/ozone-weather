<?php

declare(strict_types=1);

namespace App\Services\WeatherServiceProvider;

use App\Services\WeatherServiceProvider\Enums\WeatherCode;
use App\Services\WeatherServiceProvider\Exceptions\ApiRequestException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Validation\Factory as ValidationFactoryInterface;
use Psr\Http\Message\ResponseInterface;

readonly class OpenMeteoProvider implements WeatherProvider
{
    private const OPEN_METEO_URL = 'https://api.open-meteo.com/v1/forecast';
    public string $apiWeatherEndPoint;

    public function __construct(
        private ClientInterface            $client,
        private ValidationFactoryInterface $factoryForValidator,
        private array                      $queryParameters = [
            // Координаты Минска
            'latitude' => 53.8978,
            'longitude' => 27.5563,
            'current' => 'temperature_2m,weather_code,cloud_cover',
        ]
    ) {
        $queryString = http_build_query($this->queryParameters);
        $this->apiWeatherEndPoint = self::OPEN_METEO_URL . '?' . $queryString;
    }

    public function getCurrentWeather(): WeatherData
    {
        try {
            $response = $this->client->request('GET', $this->apiWeatherEndPoint);
        } catch (\Exception $e) {
            throw new ApiRequestException($e->getMessage());
        }

        return $this->validateResponse($response);
    }

    private function validateResponse(ResponseInterface $response): WeatherData
    {
        if ($response->getStatusCode() >= 400) {
            throw new ApiRequestException(
                'Данные с API не были получены. Статус ответа: ' . $response->getStatusCode()
            );
        }

        $validWeatherCodes = array_column(WeatherCode::cases(), 'value');
        $rules = [
            'current.time' => 'required|date_format:Y-m-d\TH:i',
            'current.temperature_2m' => 'required|numeric|min:-70|max:70',
            'current.cloud_cover' => 'required|numeric|min:0|max:100',
            'current.weather_code' => [
                'required',
                'integer',
                'in:' . implode(',', $validWeatherCodes),
            ],
        ];

        $data = json_decode($response->getBody()->getContents(), true);

        $validator = $this->factoryForValidator->make($data, $rules);
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
