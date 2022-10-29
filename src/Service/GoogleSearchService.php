<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleSearchService
{
    private const TOP_RESULTS = 10;

    public function __construct(
        private HttpClientInterface $client,
        private string $googleSearchKey,
        private string $googleSearchUrl,
    ) {}

    public function search(string $query, string $lang, int $top): array
    {
        $body = [
            'api_key'   => $this->googleSearchKey,
            'q'         => $query,
            'num'       => $top,
            'hl'        => $lang,
            'gl'        => 'ua',
            'device'    => 'desktop',
        ];

        $response = $this->client->request('GET', $this->googleSearchUrl, [
            'query' => $body,
        ])->toArray();

        return $response['organic_results'] ?? [];
    }

    public function getTopPosition(string $query, string $url_part, string $lang = 'ru', int $top = self::TOP_RESULTS)
    {
        $top = min($top, 100);
        $top = max($top, 10);

        $position = 0;
        $results = $this->search($query, $lang, $top);

        foreach ($results as $result) {
            $position++;

            if (str_contains($result['link'], $url_part)) {
                break;
            }
        }

        return $position;
    }
}