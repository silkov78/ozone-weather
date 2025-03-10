<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WeatherServiceProvider\OpenMeteoProvider;
use App\Services\WeatherServiceProvider\WeatherProvider;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Contracts\Validation\Factory as ValidatorInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WeatherProvider::class, OpenMeteoProvider::class);

        $this->app->bind(ClientInterface::class, GuzzleClient::class);

        $this->app->bind(ValidatorInterface::class, ValidatorFactory::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
