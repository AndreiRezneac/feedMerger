<?php

namespace App\Service;

use App\Entity\FeedItem;
use App\Service\Provider\FeedItemProvider;

class TwoSourcesFeedBuilder implements FeedBuilder
{
    private FeedItemProvider $itemProviderOne;
    private FeedItemProvider $itemProviderTwo;

    public function __construct(FeedItemProvider $itemProviderOne, FeedItemProvider $itemProviderTwo)
    {
        $this->itemProviderOne = $itemProviderOne;
        $this->itemProviderTwo = $itemProviderTwo;
    }

    /** @return FeedItem[] */
    public function getItems(): array
    {
        $itemsFromSourceOne = iterator_to_array($this->itemProviderOne->get());
        $itemsFromSourceTwo = iterator_to_array($this->itemProviderTwo->get());

        $allItems = array_merge($itemsFromSourceOne, $itemsFromSourceTwo);

        return $this->sortItemsByPostedAtDesc($allItems);
    }

    /**
     * @param FeedItem[] $allItems
     * @return FeedItem[]
     */
    private function sortItemsByPostedAtDesc(array $allItems): array
    {
        uasort(
            $allItems,
            fn(FeedItem $current, FeedItem $next): int => $next->getPublishedAt() <=> $current->getPublishedAt()
        );

        return $allItems;
    }
}