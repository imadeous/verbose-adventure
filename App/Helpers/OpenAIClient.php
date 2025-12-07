<?php

namespace App\Helpers;

use Exception;

/**
 * OpenAI Client — flexible prompt-based usage
 * Supports Chat Completions API
 */
class OpenAIClient
{
    private string $apiKey;
    private string $baseUrl;
    private string $defaultModel;
    private float $defaultTemperature;
    private ?int $defaultMaxTokens;

    public function __construct(
        string $apiKey,
        string $baseUrl = 'https://api.openai.com/v1',
        string $defaultModel = 'gpt-4',
        float $defaultTemperature = 0.7,
        ?int $defaultMaxTokens = 1500
    ) {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->defaultModel = $defaultModel;
        $this->defaultTemperature = $defaultTemperature;
        $this->defaultMaxTokens = $defaultMaxTokens;
    }

    /**
     * Create an instance from environment variables
     */
    public static function fromEnv(): self
    {
        $apiKey = $_ENV['OPENAI_API_KEY'] ?? '';
        if (empty($apiKey)) {
            throw new Exception('OPENAI_API_KEY is not set in environment variables');
        }

        return new self(
            apiKey: $apiKey,
            baseUrl: $_ENV['OPENAI_BASE_URL'] ?? 'https://api.openai.com/v1',
            defaultModel: $_ENV['OPENAI_MODEL'] ?? $_ENV['MODEL'] ?? 'gpt-4',
            defaultTemperature: (float) ($_ENV['OPENAI_TEMPERATURE'] ?? $_ENV['TEMPERATURE'] ?? 0.7),
            defaultMaxTokens: isset($_ENV['OPENAI_MAX_TOKENS']) || isset($_ENV['MAX_TOKENS'])
                ? (int) ($_ENV['OPENAI_MAX_TOKENS'] ?? $_ENV['MAX_TOKENS'])
                : 1500
        );
    }

    /**
     * Send a chat-completion request with fully dynamic messages.
     *
     * @param string|null $model Override default model
     * @param array $messages  Example:
     *   [
     *     ["role" => "system", "content" => "You are a helpful assistant"],
     *     ["role" => "user", "content" => "Write a poem"]
     *   ]
     * @param float|null $temperature Override default temperature
     * @param int|null $maxTokens Override default max tokens
     *
     * @return array|null
     */
    public function chat(
        array $messages,
        ?string $model = null,
        ?float $temperature = null,
        ?int $maxTokens = null
    ): ?array {
        $payload = [
            "model" => $model ?? $this->defaultModel,
            "messages" => $messages,
            "temperature" => $temperature ?? $this->defaultTemperature,
        ];

        $tokens = $maxTokens ?? $this->defaultMaxTokens;
        if ($tokens !== null) {
            $payload["max_tokens"] = $tokens;
        }

        // Add optional parameters from env if available
        if (isset($_ENV['TOP_P'])) {
            $payload["top_p"] = (float) $_ENV['TOP_P'];
        }
        if (isset($_ENV['FREQUENCY_PENALTY'])) {
            $payload["frequency_penalty"] = (float) $_ENV['FREQUENCY_PENALTY'];
        }
        if (isset($_ENV['PRESENCE_PENALTY'])) {
            $payload["presence_penalty"] = (float) $_ENV['PRESENCE_PENALTY'];
        }

        return $this->request('/chat/completions', $payload);
    }

    /**
     * Core request handler
     */
    private function request(string $endpoint, array $payload): ?array
    {
        $ch = curl_init("{$this->baseUrl}{$endpoint}");

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                "Content-Type: application/json",
                "Authorization: Bearer {$this->apiKey}"
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload),
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception("OpenAI request error: " . curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}
