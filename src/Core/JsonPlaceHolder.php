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

    public function getPosts($limit = 5):array
    {
        try{
            $data = $this->httpClient->get(self::BASE_URL . 'posts');
            if($data->getStatusCode() !== 200){
                return ['error' => 'Não foi possível buscar postagens'];
            }
            foreach (array_slice(json_decode($data->getBody()->getContents(), true), 0, $limit) as $post) {
                $posts[] = [
                    'id'    => $post['id'],
                    'title' => $post['title'],
                    'body'  => $post['body'],
                ];
            }

            return $posts;

        }catch(\Exception $e){
            return ['error' => 'Não foi possível buscar postagens'];
        }
    }

}
