<?php

namespace WeatherKata;

use DateTime;
use WeatherKata\Http\Client;

class Forecast
{
    public function __construct(
        private readonly Client $client = new Client(),
    ) {
    }

    public function predict(
        string &$city,
        bool $wind = false,
        DateTime $datetime = new DateTime(),
    ): string {
        $thisWeek = new DateTime("+6 days 00:00:00");
        if ($datetime > $thisWeek) {
            return "";
        }

        // Find the id of the city on metawheather
        $whereOnEarthId = $this->client->get("https://www.metaweather.com/api/location/search/?query=$city");
        $city = $whereOnEarthId;

        // Find the predictions for the city
        $predictions = $this->client->get("https://www.metaweather.com/api/location/$city");

        foreach ($predictions as $prediction) {
            $prediction = Prediction::create(
                $prediction['applicable_date'],
                $prediction['wind_speed'],
                $prediction['weather_state_name'],
            );
            // When the date is the expected
            $dateIsTheExpected = $prediction->applicableDate() == $datetime->format('Y-m-d');
            if ($dateIsTheExpected && $wind) {
                // If we have to return the wind information
                return $prediction->windSpeed();
            }
            if ($dateIsTheExpected && !$wind) {
                return $prediction->weatherStateName();
            }
        }
        return "";
    }
}
