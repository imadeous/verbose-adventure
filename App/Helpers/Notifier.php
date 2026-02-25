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
    private function request(string $endpoint, array $payload): void
    {
        $url = $this->baseUrl . $endpoint;

        $attempt = 0;
        $delay   = 1;

        while ($attempt < $this->maxRetries) {

            $ch = curl_init($url);

            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => $this->timeout
            ]);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                curl_close($ch);
                $attempt++;
                sleep($delay);
                $delay *= 2; // exponential backoff
                continue;
            }

            curl_close($ch);

            $decoded = json_decode($response, true);

            if (!$decoded || !isset($decoded['ok']) || $decoded['ok'] !== true) {
                $attempt++;
                sleep($delay);
                $delay *= 2;
                continue;
            }

            return; // success
        }

        throw new Exception("Telegram API request failed after {$this->maxRetries} attempts.");
    }
}
