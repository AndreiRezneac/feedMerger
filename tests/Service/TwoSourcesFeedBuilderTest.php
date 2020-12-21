<?php

namespace App\Tests\Service;

use App\Entity\FeedItem;
use App\Service\Provider\FeedItemProvider;
use App\Service\TwoSourcesFeedBuilder;
use DateTime;
use Generator;
use PHPUnit\Framework\TestCase;

class TwoSourcesFeedBuilderTest extends TestCase
{

    public function testSortsItemByDateDesc()
    {
        $providerOne = $this->createMock(FeedItemProvider::class);
        $providerOne->method('get')->will($this->returnCallback([$this, 'getItemsFromProviderOne']));

        $providerTwo = $this->createMock(FeedItemProvider::class);
        $providerTwo->method('get')->will($this->returnCallback([$this, 'getItemsFromProviderTwo']));

        $subject = new TwoSourcesFeedBuilder($providerOne, $providerTwo);
        $result = $subject->getItems();

        $actualTitles = array_map(
            fn(FeedItem $item): string => $item->getTitle(),
            $result
        );
        $expectedTitles = [
            '1days ago',
            '2days ago',
            '3days ago',
            '4days ago',
            '5days ago',
        ];
        $this->assertSame($expectedTitles, array_values($actualTitles));
    }

    public function getItemsFromProviderOne(): Generator
    {
        $items = [
            new FeedItem('2days ago', 'w', 'p', new DateTime('-2 days')),
            new FeedItem('1days ago', 'w', 'p', new DateTime('-1 day')),
            new FeedItem('5days ago', 'w', 'p', new DateTime('-5 days')),
        ];

        foreach ($items as $item) {
            yield $item;
        }
    }

    public function getItemsFromProviderTwo(): Generator
    {
        $items = [
            new FeedItem('4days ago', 'w', 'p', new DateTime('-4 days')),
            new FeedItem('3days ago', 'w', 'p', new DateTime('-3 day')),
        ];

        foreach ($items as $item) {
            yield $item;
        }
    }
}
