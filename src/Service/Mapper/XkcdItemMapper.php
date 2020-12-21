<?php

namespace App\Service\Mapper;

use App\Entity\FeedItem;
use DateTimeImmutable;
use DateTimeInterface;

class XkcdItemMapper implements FeedItemMapper
{
    private const WEB_URL_FORMAT = 'https://xkcd.com/%d/';
    private const TITLE = 'title';
    private const NUM = 'num';
    private const IMG = 'img';
    private const YEAR = 'year';
    private const MONTH = 'month';
    private const DAY = 'day';

    public function map(string $json): FeedItem
    {
        $decoded = json_decode($json, true);

        $title = $decoded[self::TITLE];
        $webUrl = sprintf(self::WEB_URL_FORMAT, $decoded[self::NUM]);
        $pictureUrl = $decoded[self::IMG];
        $publishedAt = $this->getPublishedAt($decoded);

        return new FeedItem($title, $webUrl, $pictureUrl, $publishedAt);
    }

    private function getPublishedAt(array $decoded): DateTimeInterface
    {
        $dateTime = sprintf(
            '%d-%d-%d',
            $decoded[self::YEAR],
            $decoded[self::MONTH],
            $decoded[self::DAY],
        );

        return DateTimeImmutable::createFromFormat('Y-m-d', $dateTime);
    }
}