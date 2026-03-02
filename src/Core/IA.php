<?php

namespace Bevith\DockerPhp\Core;

use Bevith\DockerPhp\Services\HttpClient;

class IA
{
    private string $apiKey;
    private HttpClient $httpClient;
    private string $url = 'https://api.openai.com/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = getenv('OPENAI_API_KEY');
        $this->httpClient = new HttpClient();
    }

    public function payload(string $userPrompt, array $context = []): array
    {
        $messages = [
            [
                'role' => 'system',
                'content' => 'Você é um assistente útil.'
            ]
        ];

      
        foreach ($context as $message) {
            if (
                isset($message['role'], $message['content']) &&
                is_string($message['content'])
            ) {
                $messages[] = $message;
            }
        }

     
        $messages[] = [
            'role' => 'user',
            'content' => $userPrompt
        ];

        return [
            'model' => 'gpt-4o-mini',
            'messages' => $messages
        ];
    }

    public function chat(string $prompt, array $context = []): array
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ];

        $payload = $this->payload($prompt, $context);

        $response = $this->httpClient->post($this->url, $payload, $headers);

        return $this->httpClient->request($response);
    }
}
