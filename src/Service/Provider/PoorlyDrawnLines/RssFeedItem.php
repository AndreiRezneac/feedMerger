<?php

namespace App\Service\Provider\PoorlyDrawnLines;

use App\Entity\FeedItem;
use DateTimeImmutable;

class RssFeedItem
{
    public string $title;
    public string $link;
    public string $pubDate;

    public function toFeedItem(): FeedItem {
        return new FeedItem(
            $this->title,
            $this->link,
            $this->link,
            new DateTimeImmutable($this->pubDate)
        );
    }
}