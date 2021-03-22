<?php

declare(strict_types=1);

namespace AppTest\unit\Move;

use App\Move\MoveResult\PickStockResult;
use App\Move\PickStockMove;
use App\Tile\Tile;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class PickStockMoveTest extends TestCase
{
    public function testInitialState(): void
    {
        $move = new PickStockMove($this->createTileSet(), $this->createTileSet());
        self::assertFalse($move->advancePlayer());
    }

    public function testExecuteWithEmptyStock(): void
    {
        $this->expectException(\LogicException::class);

        $stock = $this->createTileSet();
        $stock->method('pop')->willReturn(null);

        $move = new PickStockMove($stock, $this->createTileSet());
        $move->execute();
    }

    public function testExecute(): void
    {
        $tile = $this->createTile();

        $stock = $this->createTileSet();
        $stock->method('pop')->willReturn($tile);

        $playersTiles = $this->createTileSet();
        $playersTiles->expects(self::once())->method('add')->with(self::identicalTo($tile));

        $move = new PickStockMove($stock, $playersTiles);
        $res = $move->execute();
        self::assertEquals(new PickStockResult($tile), $res);
    }

    /**
     * @return TileSet|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createTileSet()
    {
        return $this->createMock(TileSet::class);
    }

    /**
     * @return Tile|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createTile()
    {
        return $this->createMock(Tile::class);
    }
}
