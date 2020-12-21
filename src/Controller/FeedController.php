<?php

namespace App\Controller;

use App\Entity\FeedItem;
use App\Service\FeedBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

class FeedController
{
    private FeedBuilder $feedBuilder;

    public function __construct(FeedBuilder $feedBuilder)
    {
        $this->feedBuilder = $feedBuilder;
    }

    public function getFeedAction(): JsonResponse
    {
        $items = $this->feedBuilder->getItems();
        $serializedItems = array_map(
            fn(FeedItem $item): string => $item->toJson(),
            $items
        );
        $payload = sprintf('[%s]', implode(',', $serializedItems));

        return JsonResponse::fromJsonString($payload);
    }
}