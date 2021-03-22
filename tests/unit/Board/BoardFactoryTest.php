<?php

declare(strict_types=1);

namespace AppTest\unit\Board;

use App\Board\Board;
use App\Board\BoardFactory;
use App\Tile\Tile;
use PHPUnit\Framework\TestCase;

class BoardFactoryTest extends TestCase
{
    public function testCreateBoard(): void
    {
        $factory = new BoardFactory();
        $res = $factory->createBoard(new Tile(1, 1));
        self::assertInstanceOf(Board::class, $res);
    }

    private function createTile()
    {
        return $this->createMock(Tile::class);
    }
}
