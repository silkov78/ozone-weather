<?php

namespace Tests\Unit\WeatherDataProvider;

use App\Services\WeatherServiceProvider\Enums\WeatherCode;
use App\Services\WeatherServiceProvider\Exceptions\ApiRequestException;
use App\Services\WeatherServiceProvider\OpenMeteoProvider;
use App\Services\WeatherServiceProvider\WeatherData;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use GuzzleHttp\ClientInterface;
use Illuminate\Validation\Validator;
use PHPUnit\Framework\TestCase;

class OpenMeteoProviderTest extends TestCase
{
    private ClientInterface $httpClient;
    private ValidationFactory $validationFactory;
    private OpenMeteoProvider $provider;

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(ClientInterface::class);
        $this->validationFactory = $this->createMock(ValidationFactory::class);

        $this->provider = new OpenMeteoProvider(
            $this->httpClient, $this->validationFactory
        );
    }

    public function test_get_current_weather_success(): void
    {
        // Simulated API Response
        $mockResponse = new Response(200, [], json_encode([
            'current' => [
                'time' => '2025-03-11T12:00',
                'temperature_2m' => 10.5,
                'cloud_cover' => 50,
                'weather_code' => 3,
            ]
        ]));

        // Mock HTTP Client to return the simulated response
        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', $this->provider->apiWeatherEndPoint)
            ->willReturn($mockResponse);

        // Mock Validator to always pass
        $mockValidator = $this->createMock(Validator::class);
        $this->validationFactory
            ->expects($this->once())
            ->method('make')
            ->willReturn($mockValidator);
        $mockValidator
            ->expects($this->once())
            ->method('fails')
            ->willReturn(false);

        // Execute the method
        $result = $this->provider->getCurrentWeather();
        $expected = new WeatherData(
            new \DateTime('2025-03-11T12:00'),
            10.5,
            50,
            WeatherCode::fromCode(3)
        );

        $this->assertEquals($expected, $result);
    }

    public function test_http_client_request_exception_handling(): void
    {
        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->willThrowException(new \Exception());

        $this->expectException(ApiRequestException::class);
        $this->provider->getCurrentWeather();
    }

    public function test_http_client_gets_400_error_status(): void
    {
        $mockResponse = new Response(400, []);

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', $this->provider->apiWeatherEndPoint)
            ->willReturn($mockResponse);

        $this->expectException(ApiRequestException::class);
        $this->provider->getCurrentWeather();
    }

    public function test_http_client_gets_500_error_status(): void
    {
        $mockResponse = new Response(500, []);

        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', $this->provider->apiWeatherEndPoint)
            ->willReturn($mockResponse);

        $this->expectException(ApiRequestException::class);
        $this->provider->getCurrentWeather();
    }

    public function test_response_has_invalid_json(): void
    {
        $mockResponse = new Response(200, [], json_encode(['some invalid json']));

        $this->httpClient
             ->expects($this->once())
             ->method('request')
             ->willReturn($mockResponse);

        // Mock validator fails
        $mockValidator = $this->createMock(Validator::class);
        $this->validationFactory
             ->expects($this->once())
             ->method('make')
             ->willReturn($mockValidator);

        $mockValidator->expects($this->once())->method('fails')->willReturn(true);

        $this->expectException(ApiRequestException::class);
        $this->provider->getCurrentWeather();
    }
}
