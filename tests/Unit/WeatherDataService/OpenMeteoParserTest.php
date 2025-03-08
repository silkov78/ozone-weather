<?php

namespace Tests\Unit\WeatherDataService;

use App\Services\WeatherDataService\Enums\WeatherCode;
use App\Services\WeatherDataService\OpenMeteoJsonParser;
use App\Services\WeatherDataService\WeatherData;
use PHPUnit\Framework\TestCase;

class OpenMeteoParserTest extends TestCase
{
    public function test_parse_json_data_method(): void
    {
        $openMeteoParser = new OpenMeteoJsonParser();
        $receivedJsonExample = '{"current":{"time":"2025-03-08T11:15","interval":900,"temperature_2m":13.2,"weather_code":0,"cloud_cover":0}}';

        $expected =  new WeatherData(
            new \DateTime('2025-03-08T11:15'),
            13.2,
            0,
            WeatherCode::fromCode(0)
        );

        $result = $openMeteoParser->parseData($receivedJsonExample);

        $this->assertEquals($expected, $result);
    }
}
