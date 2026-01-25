<?php

namespace Bevith\DockerPhp\Core;

use Bevith\DockerPhp\Services\HttpClient;

class OpenWeather
{
    private const BASE_URL = 'https://api.openweathermap.org';

    private HttpClient $httpClient;
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->httpClient = new HttpClient();
        $this->apiKey     = $apiKey;
    }

   
    public function currentWeather(string $city): array
    {
        try {
            $data = $this->getAPI('/data/2.5/weather', [
                'q' => $city,
            ]);

            if (!isset($data['main'], $data['weather'][0])) {
                return ['erro' => 'Cidade não encontrada'];
            }

            return [
                'temp'        => (int) round($data['main']['temp']),
                'temp_min'    => (int) round($data['main']['temp_min']),
                'temp_max'    => (int) round($data['main']['temp_max']),
                'humidity'    => (int) $data['main']['humidity'],
                'wind'        => (int) round($data['wind']['speed'] ?? 0),
                'description' => $data['weather'][0]['description'] ?? '',
                'icon'        => $data['weather'][0]['icon'] ?? '',
            ];
        } catch (\Throwable $e) {
            return ['erro' => 'Cidade não encontrada'];
        }
    }

    public function weaterForecast($city)
    {
        try {
            $data = $this->getAPI('/data/2.5/forecast', [
                'q' => $city,
            ]);

          echo '<pre>';
            var_dump($data);
            echo '</pre>';
            exit;

             $forecast = [];

             foreach(array_slice($data['list'], 0, 3) as $item) {
                 $forecast[] = [
                     'date'        => $item['dt_txt'],
                     'temp'        => (int) round($item['main']['temp']),
                     'temp_min'    => (int) round($item['main']['temp_min']),
                     'temp_max'    => (int) round($item['main']['temp_max']),
                     'humidity'    => (int) $item['main']['humidity'],
                     'wind'        => (int) round($item['wind']['speed'] ?? 0),
                     'description' => $item['weather'][0]['description'] ?? '',
                     'icon'        => $item['weather'][0]['icon'] ?? '',
                 ];
             }
                
            return $forecast;

        }  catch (\Throwable $e) {
            return ['erro' => 'Cidade não encontrada'];
        }

    }

   
    private function getAPI(string $resource, array $params = []): array
    {
        $params['units'] = 'metric';
        $params['lang']  = 'pt_br';
        $params['appid'] = $this->apiKey;

        $response = $this->httpClient->get(
            self::BASE_URL . $resource,
            $params
        );

        return json_decode(
            $response->getBody()->getContents(),
            true
        );
    }
}
