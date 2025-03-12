<?php

namespace Tests\Unit\WeatherDataProvider;

use App\Services\WeatherServiceProvider\Enums\WeatherCode;
use PHPUnit\Framework\TestCase;

class WeatherCodeTest extends TestCase
{
    public function test_conversion_int_code_in_enum(): void
    {
        $this->assertSame(
            WeatherCode::FOG,
            WeatherCode::fromCode(45)
        );
    }

    public function test_conversion_missing_int_code_in_enum(): void
    {
        $this->assertSame(
            WeatherCode::UNDEFINED,
            WeatherCode::fromCode(888)
        );
    }
}
