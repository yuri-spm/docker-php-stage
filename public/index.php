<?php

use Bevith\DockerPhp\Core\JsonPlaceHolder;

require_once __DIR__ . '/../vendor/autoload.php';

$post = (new JsonPlaceHolder())->getPost(1);
echo "<pre>";
var_dump($post);
echo "</pre>";

echo "<hr>";

$createPost = (new JsonPlaceHolder())->createPost(
    'Meu novo post 2',
    'Conteúdo do meu novo post 2',
    2
);

if (isset($createPost['error'])) {
    echo "Erro ao criar post: " . $createPost['error'];
} else {
    echo "Post criado com sucesso:";
    echo "<pre>";
    print_r($createPost);
    echo "</pre>";
}

echo "<hr>";

$deletePost = (new JsonPlaceHolder())->deletePost(1);
echo "<pre>";
var_dump($deletePost);
echo "</pre>";


echo "<hr>";

$updatePosts = (new JsonPlaceHolder())->updatePost('1', 'Título atualizado', 'Conteúdo atualizado', 1);
echo "<pre>";
var_dump($updatePosts);
echo "</pre>";