<?php

namespace WeatherKata;

use WeatherKata\Http\Client;

class Prediction
{
    public function __construct(
        private string $applicableDate,
        private float $windSpeed,
        private string $weatherStateName,
    ){
    }

    public function applicableDate(): string
    {
        return $this->applicableDate;
    }

    public function windSpeed(): float
    {
        return $this->windSpeed;
    }

    public function weatherStateName(): float
    {
        return $this->weatherStateName;
    }
    
}
