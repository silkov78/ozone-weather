<?php

declare(strict_types=1);

namespace App\Services\WeatherDataService;

use App\Services\WeatherDataService\Exceptions\RequestApiException;
use App\Services\WeatherDataService\Interfaces\WeatherJsonParserInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

readonly class WeatherDataService
{
    public function __construct(
        public Client $client,
        public WeatherJsonParserInterface $weatherJsonParser,
        public string $url,
        public array $params = [],
    ) {
    }

    public function getWeatherData(): WeatherData
    {
        // ??? Как тут обработать возможные ошибки
        try {
            $response = $this->client->get($this->url, $this->params);
            $jsonString = $response->getBody()->getContents();
        } catch (GuzzleException $e) {http://localhost/
            throw new RequestApiException("Не удалось получить данные с API: " . $e->getMessage());
        }

        return $this->parseJsonString($jsonString);
    }

    private function parseJsonString(string $jsonString): WeatherData
    {
        return $this->weatherJsonParser->parseData($jsonString);
    }
}
