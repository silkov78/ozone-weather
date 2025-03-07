<?php

declare(strict_types=1);

namespace App\Services\WeatherDataService;

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

    public function getWeatherData(): array
    {
        try {
            $response = $this->client->get($this->url, $this->params);
            $jsonString = $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            throw new \RuntimeException("Failed to fetch weather data: " . $e->getMessage());
        }

        return $this->parseJsonString($jsonString);
    }

    private function parseJsonString(string $jsonString): array
    {
        return $this->weatherJsonParser->parseData($jsonString);
    }
}
