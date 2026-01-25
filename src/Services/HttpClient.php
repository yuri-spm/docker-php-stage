<?php

namespace Bevith\DockerPhp\Services;


class HttpClient
{
    private $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function get($url, $header = [])
    {
        $response = $this->client->request('GET', $url, [
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
}
