<?php

namespace App\Service;

use App\Entity\FeedItem;

interface FeedBuilder
{
    /** @return FeedItem[] */
    public function getItems(): array;
}