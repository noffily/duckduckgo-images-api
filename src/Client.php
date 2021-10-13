<?php

declare(strict_types=1);

namespace DuckDuckGoImages;

use JsonException;

/**
 * This is unofficial DuckDuckGo images API client and created just for fun.
 * Please, use that package carefully and only for education purposes.
 * The official API is @link https://duckduckgo.com/api
 *
 * @author Andrey Chepurnoy <noffily@gmail.com>
 */
class Client
{
    public const TOKEN_ENTRYPOINT = 'https://duckduckgo.com/';
    public const API_ENTRYPOINT = 'https://duckduckgo.com/i.js';
    protected const PARAMS = [
        'l' => 'wt-wt',
        'o' => 'json',
        'f' => ',,,',
    ];

    private int $timeout;

    public function __construct(int $timeout = 5)
    {
        $this->timeout = $timeout;
    }

    /**
     * Returns array of images for provided query
     * @param string $query The search query
     * @param bool $moderate Indicator for moderate search
     * @return array
     * @throws Exception
     */
    public function getImages(string $query, bool $moderate = false): array
    {
        $token = $this->getToken($query);
        $params = array_merge(self::PARAMS, [
            'q' => $query,
            'vqd' => $token,
            'p' => $moderate ? '1' : '-1'
        ]);

        try {
            return json_decode(
                $this->sendRequest(self::API_ENTRYPOINT, $params),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            throw new Exception('Failed to parse JSON response.', 0, $e);
        }
    }

    /**
     * Returns token string, that required param for i.js entrypoint
     * @param string $query
     * @return string
     * @throws Exception
     */
    protected function getToken(string $query): string
    {
        $response = $this->sendRequest(self::TOKEN_ENTRYPOINT, [
            'q' => $query
        ]);

        preg_match('/vqd=([\d-]+)&/', $response, $matches);
        return $matches[1] ?? '';
    }

    /**
     * Executes curl request for provided entrypoint and query params
     * @throws Exception
     */
    private function sendRequest(string $entrypoint, array $queryParams): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $entrypoint . '?' . http_build_query($queryParams));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        $response = curl_exec($ch);

        if (is_bool($response)) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }

        curl_close($ch);
        return $response;
    }
}
