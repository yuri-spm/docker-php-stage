<?php

namespace Bevith\DockerPhp\Core;

use GuzzleHttp\Client;

class IA
{
    private Client $client;

    public function __construct(
        private readonly string $systemPrompt = 'Você é um assistente objetivo e direto. Responda de forma curta e concisa. Sem introduções, sem conclusões. Vá direto ao ponto.',
    ) {
        $apiKey = getenv('API_KEY');

        if (!$apiKey) {
            throw new \InvalidArgumentException('API_KEY environment variable is not set.');
        }

        $this->client = new Client([
            'base_uri' => 'https://api.groq.com/openai/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ],
        ]);
    }

    public function chat(string $message, string $model = 'llama-3.3-70b-versatile'): string
    {
        $response = $this->client->post('chat/completions', [
            'json' => [
                'model'    => $model,
                'messages' => [
                    ['role' => 'system', 'content' => $this->systemPrompt],
                    ['role' => 'user',   'content' => $message],
                ],
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['choices'][0]['message']['content'] ?? '';
    }

    public function chatWithWeather(string $question, array $weatherData): string
    {
        $context = sprintf(
            "Dados climáticos atuais: temperatura %d°C (min: %d°C, max: %d°C), umidade %d%%, vento %d km/h, condição: %s.",
            $weatherData['temp'],
            $weatherData['temp_min'],
            $weatherData['temp_max'],
            $weatherData['humidity'],
            $weatherData['wind'],
            $weatherData['description'],
        );

        return $this->chat("Contexto: {$context}\n\nPergunta: {$question}");
    }
}