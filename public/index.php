<?php

use Bevith\DockerPhp\Core\JsonPlaceHolder;

require_once __DIR__ . '/../vendor/autoload.php';


$response = (new JsonPlaceHolder())->getPosts();

echo '<pre>';
var_dump($response);
echo '</pre>';