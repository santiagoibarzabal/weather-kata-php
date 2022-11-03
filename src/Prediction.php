<?php

namespace WeatherKata;

use WeatherKata\Http\Client;

class Prediction
{
    private function __construct(
        private readonly string $applicableDate,
        private readonly float $windSpeed,
        private readonly string $weatherStateName,
    ){
    }

    public static function create(
        string $applicableDate,
        float $windSpeed,
        string $weatherStateName,
    ): self {
        return new self(
            $applicableDate,
            $windSpeed,
            $weatherStateName,
        );
    }

    public function applicableDate(): string
    {
        return $this->applicableDate;
    }

    public function windSpeed(): float
    {
        return $this->windSpeed;
    }

    public function weatherStateName(): string
    {
        return $this->weatherStateName;
    }

}
