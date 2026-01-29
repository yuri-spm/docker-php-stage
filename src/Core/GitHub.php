<?php

namespace Bevith\DockerPhp\Core;

use Bevith\DockerPhp\Services\HttpClient;

class GitHub 
{
    private const BASE_URL = 'https://api.github.com/';
    private HttpClient $httpClient;
    private $apiKey;
    

    public function __construct()
    {
        $this->httpClient = new HttpClient();
        $this->apiKey = getenv("GITHUB_API_KEY");
    }

    public function getUserRepos($user, $limit = 30)
    {
        $response = self::request(
            $this->httpClient->get(
                self::BASE_URL . "users/{$user}/repos?per_page",
                [
                    'per_page' => $limit
                ],
                [
                    'Autorization' => 'Bearer'. $this->apiKey,
                    'User-Agent' => 'Bevith-App',
                ]
            )
        );
        return $response;

           
    }

    public function getRepoIssues($user, $repo, $limit = 5)
    {
        $response = self::request(
            $this->httpClient->get(self::BASE_URL . "repos/{$user}/{$repo}/commits")
        );
        return $response;
    }

     public function getAuthUserRepos($limit = 100)
    {
        $response = self::request(
            $this->httpClient->get(
                self::BASE_URL . "user/repos",
                [
                    'per_page' => $limit
                ],
                [   'Accept' => 'application/vnd.github+json',
                    'Authorization' => 'Bearer '. $this->apiKey,
                    'User-Agent' => 'Bevith-App',
                ]
            )
        );
        return $response;

           
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