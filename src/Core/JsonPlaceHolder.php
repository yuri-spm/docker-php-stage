<?php

namespace Bevith\DockerPhp\Core;

use Bevith\DockerPhp\Services\HttpClient;

class JsonPlaceHolder
{
    const BASE_URL = 'https://jsonplaceholder.typicode.com/';
    private HttpClient $httpClient;

    public function __construct()
    {
        $this->httpClient = new HttpClient();
    }

    public function getPosts($limit = 5): array
    {
        $data = self::request($this->httpClient->get(self::BASE_URL . 'posts'));
        foreach (array_slice($data, 0, $limit) as $post) {
            $posts[] = [
                    'user_id' => $post['userId'],
                    'id'      => $post['id'],
                    'title'   => $post['title'],
                    'body'   => $post['body'],
                ];
        }
        return $posts ?? [];
    }

    public function getPost($id) 
    {
        $data = self::request($this->httpClient->get(self::BASE_URL . 'posts/' . $id));
        return $data;
    }

    public function getComments($postId): array
    {
        $data = self::request($this->httpClient->get(self::BASE_URL . 'posts/' . $postId . '/comments'));
        return $data;
    }


    private function request($response)
    {
        try {
            $data = $response;
            if ($data->getStatusCode() !== 200) {
                return ['error' => 'Não foi possível buscar postagens'];
            }

            return json_decode($data->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return ['error' => 'Não foi possível buscar postagens'];
        }
    }
}
