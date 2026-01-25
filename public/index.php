<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Bevith\DockerPhp\Core\ViaCEp;
use Bevith\DockerPhp\Core\OpenWeather;

$cep = new ViaCEp();

$result = $cep->getAddressByZipCode('21235720');


$city = $result['estado'];

var_dump($city);

echo "<hr>";



$openWeatherApiKey = getenv('OPENWEATHER_API_KEY');

$openWeather = new OpenWeather($openWeatherApiKey);


$weather2 = $openWeather->currentWeather((string) $city);

echo "<pre>";
var_dump($weather2);
echo "</pre>";

