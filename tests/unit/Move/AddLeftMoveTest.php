<?php

declare(strict_types=1);

namespace AppTest\unit\Move;

use App\Board\Board;
use App\Move\AddLeftMove;
use App\Move\MoveResult\AddLeftResult;
use App\Tile\Tile;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class AddLeftMoveTest extends TestCase
{
    public function testInitialState(): void
    {
        $move = new AddLeftMove($this->createBoard(), $this->createTile(), $this->createTileSet());
        self::assertTrue($move->advancePlayer());
    }

    public function testExecute(): void
    {
        $tile = $this->createTile();
        $tile->expects(self::never())->method(self::anything());

        $oldLeft = $this->createTile();

        $board = $this->createBoard();
        $board->expects(self::once())->method('getLeft')->willReturn($oldLeft);
        $board->expects(self::once())->method('addLeft')->with(self::identicalTo($tile));

        $playerTiles = $this->createTileSet();
        $playerTiles->expects(self::once())->method('remove')->with(self::identicalTo($tile));

        $move = new AddLeftMove($board, $tile, $playerTiles);
        $res = $move->execute();
        self::assertEquals(
            new AddLeftResult($board, $oldLeft),
            $res
        );
    }

    /**
     * @return Board|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createBoard()
    {
        return $this->createMock(Board::class);
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
