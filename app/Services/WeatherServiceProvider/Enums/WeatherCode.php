<?php

declare(strict_types=1);

namespace App\Services\WeatherServiceProvider\Enums;

/**
 * WeatherCode перечисляет все возможные состоянии погоды.
 * Кодировки утверждены WMO (являются общепринятыми).
 * Если провалидированные данные содержат код, непредставленный в перечислении,
 * ему присваивается код UNDEFINED.
 *
 * Ссылка на источник: https://open-meteo.com/en/docs (перечислены в конце)
 */
enum WeatherCode: int
{
    case UNDEFINED = -1;
    case CLEAR_SKY = 0;
    case MAINLY_CLEAR = 1;
    case PARTLY_CLOUDY = 2;
    case OVERCAST = 3;
    case FOG = 45;
    case DEPOSITING_RIME_FOG = 48;
    case DRIZZLE_LIGHT = 51;
    case DRIZZLE_MODERATE = 53;
    case DRIZZLE_DENSE = 55;
    case FREEZING_DRIZZLE_LIGHT = 56;
    case FREEZING_DRIZZLE_DENSE = 57;
    case RAIN_LIGHT = 61;
    case RAIN_MODERATE = 63;
    case RAIN_HEAVY = 65;
    case FREEZING_RAIN_LIGHT = 66;
    case FREEZING_RAIN_HEAVY = 67;
    case SNOW_FALL_LIGHT = 71;
    case SNOW_FALL_MODERATE = 73;
    case SNOW_FALL_HEAVY = 75;
    case SNOW_GRAINS = 77;
    case THUNDERSTORM_SLIGHT = 95;
    case THUNDERSTORM_HEAVY = 99;

    public static function fromCode(int $code): self
    {
        return self::tryFrom($code) ?? self::UNDEFINED;
    }
}
