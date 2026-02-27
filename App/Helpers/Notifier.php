<?php

namespace App\Helpers;

use Exception;
use CURLFile;

/**
 * Class Notifier
 *
 * Robust Telegram notification service.
 * - Supports text and photo messages
 * - Retries failed requests
 * - Throws Exceptions on failure
 */
class Notifier
{
    private string $botToken;
    private array $chatIds;
    private string $baseUrl;
    private int $maxRetries;
    private int $timeout;

    /**
     * @param string $botToken
     * @param array  $chatIds
     * @param int    $maxRetries
     * @param int    $timeout
     */
    public function __construct(
        string $botToken,
        array $chatIds,
        int $maxRetries = 3,
        int $timeout = 10
    ) {
        $this->botToken   = $botToken;
        $this->chatIds    = $chatIds;
        $this->baseUrl    = "https://api.telegram.org/bot{$botToken}/";
        $this->maxRetries = $maxRetries;
        $this->timeout    = $timeout;
    }

    /**
     * Send plain text message
     *
     * @param string $message
     * @throws Exception
     */
    public function send(string $message): void
    {
        foreach ($this->chatIds as $chatId) {
            $this->request('sendMessage', [
                'chat_id' => $chatId,
                'text'    => $message
            ]);
        }
    }

    /**
     * Send photo with optional caption
     *
     * @param string|CURLFile $photo
     * @param string|null $caption
     * @throws Exception
     */
    public function sendPhoto(string|CURLFile $photo, ?string $caption = null): void
    {
        foreach ($this->chatIds as $chatId) {

            $payload = [
                'chat_id' => $chatId,
                'photo'   => $photo
            ];

            if ($caption) {
                $payload['caption'] = $caption;
            }

            $this->request('sendPhoto', $payload);
        }
    }

    /**
     * Quick static notification helper
     *
     * @param string      $status   SUCCESS | ERROR | INFO | WARNING
     * @param string      $message  Main message body
     * @param string|null $datetime Optional datetime string
     * @param string|null $emoji    Optional emoji override
     *
     * @throws Exception
     */
    public static function notify(
        string $status,
        string $message,
        ?string $datetime = null,
        ?string $emoji = null
    ): void {

        $botToken = getenv('TELEGRAM_BOT_TOKEN');
        $chatIds  = explode(',', getenv('TELEGRAM_CHAT_IDS'));

        $instance = new self($botToken, $chatIds);

        // Default emoji by status
        $defaultEmojis = [
            'SUCCESS' => '✅',
            'ERROR'   => '❌',
            'WARNING' => '⚠️',
            'INFO'    => 'ℹ️'
        ];

        $status = strtoupper($status);

        if (!isset($defaultEmojis[$status])) {
            $status = 'INFO';
        }

        $emoji = $emoji ?? $defaultEmojis[$status];
        $datetime = $datetime ?? date('Y-m-d H:i:s');

        $formattedMessage  = "{$emoji} {$status}\n\n";
        $formattedMessage .= "{$message}\n\n";
        $formattedMessage .= "🕒 {$datetime}";

        $instance->send($formattedMessage);
    }

    /**
     * Core request handler with retry logic
     *
     * @param string $endpoint
     * @param array  $payload
     * @throws Exception
     */
    private function request(string $endpoint, array $params)
    {
        $url = "https://api.telegram.org/bot{$this->botToken}/{$endpoint}";

        $attempts = 0;
        $maxAttempts = 3;

        while ($attempts < $maxAttempts) {

            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $params,
                CURLOPT_TIMEOUT => 10,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);

            curl_close($ch);

            if ($response === false) {
                $attempts++;
                continue;
            }

            $decoded = json_decode($response, true);

            // SUCCESS CASE
            if ($httpCode === 200 && isset($decoded['ok']) && $decoded['ok'] === true) {
                return true;
            }

            $attempts++;
        }

        throw new Exception("Telegram API request failed after {$maxAttempts} attempts.");
    }
}
