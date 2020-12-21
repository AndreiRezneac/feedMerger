<?php

namespace App\Service\Provider\Xkcd;

use App\Entity\FeedItem;
use App\Service\Mapper\FeedItemMapper;
use App\Service\Provider\FeedItemProvider;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class XkcdItemProvider implements FeedItemProvider
{
    private const URL_TEMPLATE = 'http://xkcd.com/%d/info.0.json';

    private int $maxItems;
    private XkcdLastNumberFetcher $lastXkcdNumberFetcher;
    private HttpClientInterface $client;
    private FeedItemMapper $feedItemMapper;

    public function __construct(
        int $maxItems,
        XkcdLastNumberFetcher $lastXkcdNumberFetcher,
        HttpClientInterface $client,
        FeedItemMapper $feedItemMapper
    ) {
        $this->maxItems = $maxItems;
        $this->lastXkcdNumberFetcher = $lastXkcdNumberFetcher;
        $this->client = $client;
        $this->feedItemMapper = $feedItemMapper;
    }

    /** @return Generator<FeedItem> */
    public function get(): Generator {
        $lastNumber = $this->lastXkcdNumberFetcher->fetch();
        $responses = $this->dispatchRequests($lastNumber);

        foreach ($this->client->stream($responses) as $response => $chunk) {
            if ($chunk->isLast()) {
                $payload = $response->getContent();

                yield $this->feedItemMapper->map($payload);
            }
        }
    }

    private function dispatchRequests(int $lastNumber): array
    {
        $responses = [];
        for ($i = $lastNumber; $i > $lastNumber - $this->maxItems; $i--) {
            $url = sprintf(self::URL_TEMPLATE, $i);
            $responses[] = $this->client->request(Request::METHOD_GET, $url);
        }

        return $responses;
    }
}