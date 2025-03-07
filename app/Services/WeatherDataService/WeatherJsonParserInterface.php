<?php

namespace App\Services\WeatherDataService;

interface WeatherJsonParserInterface
{
    public function parseData(string $jsonString): array;
}
