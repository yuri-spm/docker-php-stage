<?php

use Bevith\DockerPhp\Core\DummyJson;
use Bevith\DockerPhp\Core\JsonPlaceHolder;
use Bevith\DockerPhp\Core\OpenWeather;
use Bevith\DockerPhp\Core\ViaCEp;
use Bevith\DockerPhp\Core\GitHub;
use Bevith\DockerPhp\Services\Helper;
use PHPUnit\TextUI\Help;

require __DIR__ . '/../vendor/autoload.php';




$data  = (new DummyJson())->getUsers(10);


// $admin = array_slice(Helper::filterRole($data, 'moderator'), 0, 5);



// echo "<pre>";
// var_dump($admin);
// echo "</pre>";
// echo "<hr>";


$departament = Helper::filterDepartament($data, 'Marketing');

echo count($departament);
echo "<hr>";

// echo "<pre>";
// var_dump($departament);
// echo "</pre>";

// $employees = Helper::countByDepartament($data, 'Marketing');
// echo "<pre>";
// var_dump($employees);
// echo "</pre>";

// echo "<hr>";

// $employees = Helper::employees($data, 'Marketing');
// echo "<pre>";
// var_dump($employees);
// echo "</pre>";

$employees = Helper::resumeDepartament($data, 'Marketing');
echo "<pre>";
var_dump($employees);
echo "</pre>";