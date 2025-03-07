<?php

declare(strict_types=1);

namespace App\Services\WeatherDataService;

class OpenMeteoParser implements WeatherJsonParserInterface
{
    public function parseData(string $jsonString): array
    {
        $data = json_decode($jsonString, true);

        var_dump($data['current']);

        return $data['current'];
    }
}
