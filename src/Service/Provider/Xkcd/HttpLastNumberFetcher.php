<?php

namespace App\Service\Provider\Xkcd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpLastNumberFetcher implements XkcdLastNumberFetcher
{
    private const URL = 'https://xkcd.com/json.html';

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetch(): int {
        $response = $this->client->request(Request::METHOD_GET, self::URL);
        $content = $response->getContent();
        preg_match('/xkcd.com.+(\d{3,}).+\.json/', $content, $matches);

        return $matches[1];
    }
}