<?php

declare(strict_types=1);

namespace AppTest\unit\Board;

use App\Board\Board;
use App\Tile\Tile;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function testInitialState(): void
    {
        $tile = new Tile(1, 2);

        $board = new Board($tile);
        self::assertSame(1, $board->getLeftValue());
        self::assertSame(2, $board->getRightValue());
        self::assertSame($tile, $board->getLeft());
        self::assertSame($tile, $board->getRight());
        self::assertSame(1, $board->getValueCount(1));
        self::assertSame(1, $board->getValueCount(2));
        self::assertSame(0, $board->getValueCount(3));
    }

    public function testAddLeftException(): void
    {
        $this->expectException(\LogicException::class);

        $board = new Board(new Tile(1, 2));
        $board->addLeft(new Tile(1, 2));
    }

    public function testAddLeftSuccess(): void
    {
        $board = new Board(new Tile(1, 2));
        $addTile = new Tile(2, 1);
        $board->addLeft($addTile);

        self::assertSame($addTile, $board->getLeft());
        self::assertSame(2, $board->getLeftValue());
        self::assertSame(2, $board->getValueCount(1));
        self::assertSame(2, $board->getValueCount(2));
    }

    public function testAddRightException(): void
    {
        $this->expectException(\LogicException::class);

        $board = new Board(new Tile(1, 2));
        $addTile = new Tile(1, 2);
        $board->addRight($addTile);
    }

    public function testAddRightSuccess(): void
    {
        $board = new Board(new Tile(1, 2));
        $addTile = new Tile(2, 1);
        $board->addRight($addTile);

        self::assertSame($addTile, $board->getRight());
        self::assertSame(1, $board->getRightValue());
        self::assertSame(2, $board->getValueCount(1));
        self::assertSame(2, $board->getValueCount(2));
    }

    public function testGetTilesIterator(): void
    {
        $t12 = new Tile(1, 2);
        $t21 = new Tile(2, 1);

        $board = new Board($t12);
        $board->addLeft($t21);
        $board->addRight($t21);

        self::assertSame(
            [$t21, $t12, $t21],
            \iterator_to_array($board->getTilesIterator())
        );
    }
}
