<?php

namespace App\Tests\Service\Mapper;

use App\Entity\FeedItem;
use App\Service\Mapper\XkcdItemMapper;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class XkcdItemMapperTest extends TestCase
{
    public function testMap()
    {
        $mapper = new XkcdItemMapper();
        $item = $mapper->map($this->getExample());
        $publishedAt = DateTimeImmutable::createFromFormat('Y-m-d', '2009-7-15');
        $expectedItem = new FeedItem(
            'Sheeple',
            'https://xkcd.com/610/',
            'https://imgs.xkcd.com/comics/sheeple.png',
            $publishedAt
        );

        $this->assertEquals($expectedItem, $item);
    }

    private function getExample(): string {
        return '
{
    "month": "7",
    "num": 610,
    "link": "",
    "year": "2009",
    "news": "",
    "safe_title": "Sheeple",
    "transcript": "I\'m the only conscious human in a world of sheep.",
    "alt": "Hey, what are the odds -- five Ayn Rand fans on the same train! Must be going to a convention.",
    "img": "https://imgs.xkcd.com/comics/sheeple.png",
    "title": "Sheeple",
    "day": "15"
}';
    }
}
