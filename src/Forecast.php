<?php

namespace WeatherKata;

use DateTime;
use WeatherKata\Services\ForecastService;

class Forecast
{
    public function __construct(
        private readonly ForecastService $forecastService = new ForecastService(),
    ) {
    }

    public function changeCityToWOEId(string $city): int
    {
        return $this->forecastService->getWOEId($city);
    }

    public function predictWindSpeed(
        string $city,
        DateTime $dateTime = new DateTime(),
    ): float {
        $prediction = $this->getPredictionByCity($city, $dateTime);
        if ($prediction instanceof Prediction) {
            return $prediction->windSpeed();
        }
        return '';
    }

    public function predictWeatherState(
        string $city,
        DateTime $dateTime = new DateTime(),
    ): string {
        $prediction = $this->getPredictionByCity($city, $dateTime);
        if ($prediction instanceof Prediction) {
            return $prediction->weatherStateName();
        }
        return '';
    }

    private function getPredictionByCity(
        string $city, 
        DateTime $dateTime = new DateTime(),
    ): Prediction|string {
        $thisWeek = new DateTime("+6 days 00:00:00");
        if ($dateTime > $thisWeek) {
            return '';
        }

        // Call the Forecast Service here
        $predictions = $this->forecastService->getForecastByCityName($city);

        foreach ($predictions as $prediction) {
            $prediction = Prediction::create(
                $prediction['applicable_date'],
                $prediction['wind_speed'],
                $prediction['weather_state_name'],
            );
            // When the date is the expected
            $dateIsTheExpected = $prediction->applicableDate() == $dateTime->format('Y-m-d');
            if ($dateIsTheExpected) {
                return $prediction;
            }
        }
        return '';
    }
}
