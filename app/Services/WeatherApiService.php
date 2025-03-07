<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

class WeatherApiService
{
    public function __construct()
    {
        $client = new Client();

        $url = 'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&current=temperature_2m,wind_speed_10m';

        $response = $client->request('GET', $url);

        echo $response->getStatusCode();
        echo $response->getBody();
    }
}
