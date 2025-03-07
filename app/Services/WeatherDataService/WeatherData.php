<?php

declare(strict_types=1);

namespace App\Services\WeatherDataService;

use App\Services\WeatherDataService\Enums\WeatherCode;

class WeatherData
{
    public function __construct(
        public \DateTime   $dateTime,
        public float       $temperature,
        public float       $cloudCover,
        public WeatherCode $weatherState,
    ) {
    }
}
