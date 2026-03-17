<?php

namespace Bevith\DockerPhp\Services;

class HttpClient
{
    private $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function get($url, $query = [], $header = [])
    {
        $response = $this->client->request('GET', $url, [
            'query' => $query,
            'headers' => $header
        ]);

        return $response;
    }

    public function post($url, $body = [], $header = [])
    {
       
        $response = $this->client->request('POST', $url, [
            'headers' => $header,
            'json' => $body
        ]);
        return $response;
    }

    public function put($url, $body = [], $header = [])
    {
        $response = $this->client->request('PUT', $url, [
            'headers' => $header,
            'json' => $body
        ]);

        return $response;
    }

    public function delete($url, $header = [])
    {
        $response = $this->client->request('DELETE', $url, [
            'headers' => $header
        ]);

        return $response;
    }

    public function patch($url, $body = [], $header = [])
    {
        $response = $this->client->request('PATCH', $url, [
            'headers' => $header,
            'json' => $body
        ]);

        return $response;
    }

    public function request($response)
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
