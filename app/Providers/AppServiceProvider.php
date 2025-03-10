<?php

namespace App\Providers;

use App\Services\WeatherServiceProvider\OpenMeteoProvider;
use App\Services\WeatherServiceProvider\WeatherProvider;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Validation\Factory as ValidatorInterface;
use Psr\Http\Message\ResponseInterface;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WeatherProvider::class, OpenMeteoProvider::class);

        // Bind Guzzle HTTP client
        $this->app->bind(ClientInterface::class, function () {
            return new Client();
        });

        // Bind Laravel Validator
        $this->app->bind(ValidatorInterface::class, function ($app) {
            return $app['validator'];
        });

        $this->app->bind(ResponseInterface::class, function () {
            return new Response();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
