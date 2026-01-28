<?php

namespace Bevith\DockerPhp\Core;

use Bevith\DockerPhp\Services\HttpClient;

class GitHub 
{
    private const BASE_URL = 'https://api.github.com/';
    private HttpClient $httpClient;
    

    public function __construct()
    {
        $this->httpClient = new HttpClient();
        $apiKey = getenv("GITHUB_API_KEY");
    }

    public function getUserRepos($user, $limit = 5)
    {
        $response = self::request(
            $this->httpClient->get(self::BASE_URL . "users/{$user}/repos?per_page={$limit}")
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