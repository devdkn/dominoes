<?php

declare(strict_types=1);

namespace AppTest\unit\Tile;

use App\Tile\Tile;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class TileTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testGetters(): void
    {
        $tile1 = new Tile(1, 2);
        self::assertSame(1, $tile1->getLeft());
        self::assertSame(2, $tile1->getRight());

        $tile2 = new Tile(2, 1);
        self::assertSame(2, $tile2->getLeft());
        self::assertSame(1, $tile2->getRight());
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testFlip(): void
    {
        $tile = new Tile(1, 2);

        $flipped = $tile->flip();
        self::assertNotSame($tile, $flipped);

        self::assertSame(1, $tile->getLeft());
        self::assertSame(2, $tile->getRight());

        self::assertSame(2, $flipped->getLeft());
        self::assertSame(1, $flipped->getRight());
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testToString(): void
    {
        $tile = new Tile(1, 2);
        self::assertSame('1:2', (string) $tile);
    }
}
