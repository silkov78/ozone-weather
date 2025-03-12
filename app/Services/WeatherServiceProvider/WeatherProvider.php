<?php

declare(strict_types=1);

namespace App\Services\WeatherServiceProvider;

/**
 * Интерфейс для получения данных о погоде
 */
interface WeatherProvider
{
    /**
     * * - запришивает данные о текущем состоянии погоды из API-погоды
     * * - валидирует полученные данные
     * * - возвращает объект WeatherData
     */
    public function getCurrentWeather(): WeatherData;
}
