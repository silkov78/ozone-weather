<?php

declare(strict_types=1);

namespace App\Services\WeatherDataService;

use App\Services\WeatherDataService\Exceptions\RequestApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class WeatherApiClient
{
    public function __construct(public Client $client) {}

    public function get(string $url, array $params = []): string
    {
        try {
            $response = $this->client->get($url, $params);
            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            throw new RequestApiException("API request failed: " . $e->getMessage());
        }
    }
}
