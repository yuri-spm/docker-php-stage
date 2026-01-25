<?php

namespace Bevith\DockerPhp\Core;

use Bevith\DockerPhp\Services\HttpClient;


class ViaCEp
{
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new HttpClient();
    }

    public function getAddressByZipCode($zipCode)
    {
      $response = $this->httpClient->get("https://viacep.com.br/ws/{$zipCode}/json/");
      if($response->getStatusCode() === 200){
          foreach (json_decode($response->getBody()->getContents(), true) as $key => $value) {
            $address[$key] = $value ;
          }
          return $address;
      } else {
          return null;
      }
    }
}