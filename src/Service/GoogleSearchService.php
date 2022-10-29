<?php

namespace App\Service;

class GoogleSearchService
{
    public function search(string $keyword): array
    {
        $url = 'https://www.google.com/search?q=' . urlencode($keyword);
        $html = file_get_contents($url);
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query('//div[@class="g"]');
        $results = [];

        foreach ($nodes as $node) {
            $result = [
                'title' => '',
                'url' => '',
                'description' => '',
            ];
            $result['title'] = $xpath->query('.//h3[@class="LC20lb DKV0Md"]', $node)->item(0)->nodeValue;
            $result['url'] = $xpath->query('.//div[@class="yuRUbf"]//a', $node)->item(0)->getAttribute('href');
            $result['description'] = $xpath->query('.//div[@class="IsZvec"]', $node)->item(0)->nodeValue;
            $results[] = $result;
        }

        return $results;
    }
}