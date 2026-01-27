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

    public function createPost($title, $body, $userId)
    {
        $postData = [
            'title' => $title,
            'body' => $body,
            'userId' => $userId
        ];

        $data = self::request($this->httpClient->post(self::BASE_URL . 'posts', $postData, ['Content-type' => 'application/json; charset=UTF-8']));
        return $data;
        
    }

    public function updatePost($id, $title, $body, $userId)
    {
        $postData = [
            'id' => $id,
            'title' => $title,
            'body' => $body,
            'userId' => $userId
        ];

        $data = self::request($this->httpClient->put(self::BASE_URL . 'posts/' . $id, $postData, ['Content-type' => 'application/json; charset=UTF-8']));
        return $data;
    }


    public function deletePost($id)
    {
        $data = self::request($this->httpClient->delete(self::BASE_URL . 'posts/' . $id));
        return $data;
    }


    private function request($response)
    {
        try {
            $data = $response;

            if ($data->getStatusCode() < 200 || $data->getStatusCode() >= 300) {
                return ['error' => 'Item não encontrado'];
            }

            return json_decode($data->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return ['error' => 'Erro ao processar requisição: ' . $e->getMessage() ];
        }
    }
}
