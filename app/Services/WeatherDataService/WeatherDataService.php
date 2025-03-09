<?php

declare(strict_types=1);

namespace App\Services\WeatherDataService;

use App\Services\WeatherDataService\Interfaces\WeatherJsonParserInterface;

readonly class WeatherDataService
{
    public function __construct(
        public WeatherApiClient $apiClient,
        public WeatherJsonParserInterface $weatherJsonParser,
        public string $url,
        public array $params = [],
    ) {}

    public function getWeatherData(): WeatherData
    {
        $jsonString = $this->apiClient->get($this->url, $this->params);
        return $this->parseJsonString($jsonString);
    }

    private function parseJsonString(string $jsonString): WeatherData
    {
        return $this->weatherJsonParser->parseData($jsonString);
    }
}
