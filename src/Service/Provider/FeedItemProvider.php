<?php

namespace App\Service\Provider;

use App\Entity\FeedItem;
use Generator;

interface FeedItemProvider
{
    /** @return Generator<FeedItem> */
    public function get(): Generator;
}