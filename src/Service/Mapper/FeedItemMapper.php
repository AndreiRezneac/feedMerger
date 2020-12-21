<?php

namespace App\Service\Mapper;

use App\Entity\FeedItem;

interface FeedItemMapper
{
    public function map(string $input): FeedItem;
}