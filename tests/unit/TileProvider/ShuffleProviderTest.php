<?php

declare(strict_types=1);

namespace AppTest\unit\TileProvider;

use App\Tile\Tile;
use App\Tile\TileSet;
use App\TileProvider\ShuffleProvider;
use App\TileProvider\TileProviderInterface;
use PHPUnit\Framework\TestCase;

class ShuffleProviderTest extends TestCase
{
    public function testProvideTiles(): void
    {
        $input = 7;
        $originalSet = new TileSet();
        $originalSet->add(new Tile(1, 2));
        $originalSet->add(new Tile(1, 3));
        $originalSet->add(new Tile(1, 4));

        $originalOrder = ['1:2', '1:3', '1:4'];

        $provider = new ShuffleProvider($this->createNestedProvider($input, $originalSet));
        $res = $provider->provideTiles($input);

        $newOrder = [];
        while (($tile = $res->pop()) !== null) {
            $newOrder[] = $tile->getLeft() . ':' . $tile->getRight();
        }
        // can't really test shuffle() results
        self::assertEqualsCanonicalizing($originalOrder, $newOrder);
    }

    /**
     * @param int     $expectedInput
     * @param TileSet $returnSet
     *
     * @return \PHPUnit\Framework\MockObject\MockObject|TileProviderInterface
     */
    private function createNestedProvider(int $expectedInput, TileSet $returnSet)
    {
        $mock = $this->getMockBuilder(TileProviderInterface::class)->getMockForAbstractClass();
        $mock->method('provideTiles')->with($expectedInput)->willReturn($returnSet);

        return $mock;
    }
}
