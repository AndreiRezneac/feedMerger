<?php

namespace App\Service\Provider\PoorlyDrawnLines;

use App\Service\Provider\FeedItemProvider;
use Generator;

class PoorlyDrawnLinesItemProvider implements FeedItemProvider
{
    private const URL = 'http://feeds.feedburner.com/PoorlyDrawnLines';

    private int $maxItems;

    public function __construct(int $maxItems)
    {
        $this->maxItems = $maxItems;
    }

    public function get(): Generator
    {
        $rssFeedXml = @simplexml_load_file(self::URL);

        $count = 0;
        foreach ($rssFeedXml->channel->item as $item) {
            if (++$count > $this->maxItems) {
                return;
            }
            $rssItem = new RssFeedItem();
            $rssItem->title = $item->title;
            $rssItem->link = $item->link;
            $rssItem->pubDate = $item->pubDate;

            yield $rssItem->toFeedItem();
        }
    }
}