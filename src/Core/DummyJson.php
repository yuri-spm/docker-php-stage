<?php

namespace Bevith\DockerPhp\Core;

use Bevith\DockerPhp\Services\HttpClient;

class DummyJson
{
    const BASE_URL = 'https://dummyjson.com/';
    private HttpClient $httpClient;

    public function __construct()
    {
        $this->httpClient = new HttpClient();
    }

    public function getUsers($limit = 5): array
    {
        $data = self::request($this->httpClient->get(self::BASE_URL . 'users'));
        return array_slice($data['users'], 0, $limit);
    }

    public function getUser($id):array
    {
        $data = self::request($this->httpClient->get(self::BASE_URL . 'users/' . $id));
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
            return ['error' => 'Erro ao processar a requisição: ' . $e->getMessage()];
        }
    }
}