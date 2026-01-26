<?php

use Bevith\DockerPhp\Core\JsonPlaceHolder;

require_once __DIR__ . '/../vendor/autoload.php';


$response = (new JsonPlaceHolder())->getPosts();

echo '<pre>';
var_dump($response);
echo '</pre>';

echo '<hr>';

$post = (new JsonPlaceHolder())->getPost(1);
echo '<pre>';
var_dump($post);
echo '</pre>';

echo '<hr>';


$coments = (new JsonPlaceHolder())->getComments(1);
echo '<pre>';
var_dump($coments);
echo '</pre>';