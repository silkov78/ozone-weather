<?php

declare(strict_types=1);

namespace App\Services\WeatherServiceProvider;

use App\Services\WeatherServiceProvider\Enums\WeatherCode;

readonly class WeatherData
{
    public function __construct(
        public \DateTime   $dateTime,
        public float       $temperature,
        public float       $cloudCover,
        public WeatherCode $weatherCode,
    ) {
    }

    public function __toString(): string
    {
        return "Weather report: city - Minsk, Temperature - {$this->temperature}°C";
    }
}
