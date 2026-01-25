<?php

namespace Bevith\DockerPhp\Core;

use Bevith\DockerPhp\Services\HttpClient;

class OpenWeather
{
    private $httpClient;
    private $apiKey;

    public function __construct($apiKey){
        $this->httpClient = new HttpClient();
        $this->apiKey = $apiKey;
    }

    
}