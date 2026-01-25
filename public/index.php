<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Bevith\DockerPhp\Core\ViaCEp;

$cep = new ViaCEp();

$result = $cep->getAddressByZipCode('21235720');

print_r($result['logradouro']);