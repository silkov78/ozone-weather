<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

class WeatherApiService
{
    public function __construct(
        string $url,
        array $params = [],
    )
    {
        // WeatherApiService
        try {
            $client = new Client();
            $response = $client->get($url, $params);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        // ResponseParser
        $data = json_decode((string) $response->getBody(), true)['current'];

        var_dump($data);
    }
}
