<?php

namespace WeatherKata\Services;

use WeatherKata\Http\Client;

class ForecastService {
  public function __construct(
    private readonly Client $client = new Client(),
  ) {}

  public function getWOEId(string $city): int {
    // Find the id of the city on metawheather
    $whereOnEarthId = $this->client->get("https://www.metaweather.com/api/location/search/?query=$city");

    return $whereOnEarthId;
  }

  public function getForecastByCityName(string $city): array {
    // get WOEId
    // Find the id of the city on metawheather
    $whereOnEarthId = $this->getWOEId($city);
    // Find the predictions for the city
    $predictions = $this->client->get("https://www.metaweather.com/api/location/$whereOnEarthId");

    return $predictions;
  }
}