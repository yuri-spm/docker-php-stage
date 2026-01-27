<?php

use Bevith\DockerPhp\Core\JsonPlaceHolder;
use Bevith\DockerPhp\Core\OpenWeather;
use Bevith\DockerPhp\Core\ViaCEp;
use Bevith\DockerPhp\Core\GitHub;


require __DIR__ . '/../vendor/autoload.php';



$repositories = (new GitHub())->getUserRepos('yuri-spm');



foreach($repositories as $repo){
    echo "Repositório: " . $repo['name'] . "<br>";
    echo "Descrição: " . $repo['description'] . "<br>";
    echo "URL: " . $repo['html_url'] . "<br>";
    echo str_repeat("-", 40) . "<br>";
    
}   