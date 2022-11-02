<?php

namespace WeatherKata;

use WeatherKata\Http\Client;

class Forecast
{

    public function predict(
        string &$city, 
        \DateTime $datetime = null,
        bool $wind = false,
        ): string {
        $thisWeek = new \DateTime("+6 days 00:00:00");
        // Why this below? VVVV
        if (!$datetime) {
            $datetime = new \DateTime();
        }
        if (!($datetime < $thisWeek)) {
            return "";
        }
        // Create a Guzzle Http Client
        $client = new Client();

        // Find the id of the city on metawheather
        $cityId = $client->get("https://www.metaweather.com/api/location/search/?query=$city");

        // Find the predictions for the city
        $predictions = $client->get("https://www.metaweather.com/api/location/$cityId");

        foreach ($predictions as $prediction) {
            // When the date is the expected
            $dateIsTheExpected = $prediction["applicable_date"] == $datetime->format('Y-m-d');
            if ($dateIsTheExpected && $wind) {
                // If we have to return the wind information
                return $prediction['wind_speed'];
            }
            if ($dateIsTheExpected && !$wind) {
                return $prediction['weather_state_name'];
            }
        }
        
    }
}
