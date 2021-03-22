<?php

declare(strict_types=1);

namespace AppTest\unit\Move;

use App\Board\Board;
use App\Move\AddRightMove;
use App\Move\MoveResult\AddRightResult;
use App\Tile\Tile;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class AddRightMoveTest extends TestCase
{
    public function testInitialState(): void
    {
        $move = new AddRightMove($this->createBoard(), $this->createTile(), $this->createTileSet());
        self::assertTrue($move->advancePlayer());
    }

    public function testExecute(): void
    {
        $tile = $this->createTile();
        $tile->expects(self::never())->method(self::anything());

        $oldRight = $this->createTile();

        $board = $this->createBoard();
        $board->expects(self::once())->method('getRight')->willReturn($oldRight);
        $board->expects(self::once())->method('addRight')->with(self::identicalTo($tile));

        $playerTiles = $this->createTileSet();
        $playerTiles->expects(self::once())->method('remove')->with(self::identicalTo($tile));

        $move = new AddRightMove($board, $tile, $playerTiles);
        $res = $move->execute();
        self::assertEquals(
            new AddRightResult($board, $oldRight),
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
