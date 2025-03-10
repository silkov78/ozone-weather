<?php

namespace Tests\Unit\WeatherDataProvider;

use App\Services\WeatherServiceProvider\OpenMeteoProvider;
use App\Services\WeatherServiceProvider\WeatherProvider;
use PHPUnit\Framework\TestCase;

class OpenMeteoProviderTest extends TestCase
{
    public function setUp(): void
    {
        $openMeteoMock = $this->createMock(WeatherProvider::class);
    }
}
