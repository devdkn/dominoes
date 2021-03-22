<?php

declare(strict_types=1);

namespace AppTest\unit\Player\MoveStrategy;

use App\Board\Board;
use App\Move\AddLeftMove;
use App\Move\AddRightMove;
use App\Move\PickStockMove;
use App\Move\SkipMove;
use App\Player\MoveStrategy\Ai\MoveTilePicker;
use App\Player\MoveStrategy\AiMoveStrategy;
use App\Tile\Tile;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class AiMoveStrategyTest extends TestCase
{
    public function testCreateMoveLeft(): void
    {
        $board = $this->createBoard();
        $stock = $this->createTileSet();
        $playerTiles = $this->createTileSet();
        $tile = $this->createTile();

        $picker = $this->createMoveTilePicker();
        $picker
            ->method('pickTileForLeftMove')
            ->with(self::identicalTo($board), self::identicalTo($playerTiles))
            ->willReturn($tile);
        $picker->expects(self::never())->method('pickTileForRightMove');

        $strategy = new AiMoveStrategy($picker);
        $res = $strategy->createMove($board, $playerTiles, $stock);
        self::assertEquals(new AddLeftMove($board, $tile, $playerTiles), $res);
    }

    public function testCreateMoveRight(): void
    {
        $board = $this->createBoard();
        $stock = $this->createTileSet();
        $playerTiles = $this->createTileSet();
        $tile = $this->createTile();

        $picker = $this->createMoveTilePicker();
        $picker
            ->method('pickTileForLeftMove')
            ->with(self::identicalTo($board), self::identicalTo($playerTiles))
            ->willReturn(null);
        $picker
            ->method('pickTileForRightMove')
            ->with(self::identicalTo($board), self::identicalTo($playerTiles))
            ->willReturn($tile);

        $strategy = new AiMoveStrategy($picker);
        $res = $strategy->createMove($board, $playerTiles, $stock);
        self::assertEquals(new AddRightMove($board, $tile, $playerTiles), $res);
    }

    public function testCreateMovePick(): void
    {
        $board = $this->createBoard();
        $stock = $this->createTileSet();
        $playerTiles = $this->createTileSet();

        $picker = $this->createMoveTilePicker();
        $picker
            ->method('pickTileForLeftMove')
            ->with(self::identicalTo($board), self::identicalTo($playerTiles))
            ->willReturn(null);
        $picker
            ->method('pickTileForRightMove')
            ->with(self::identicalTo($board), self::identicalTo($playerTiles))
            ->willReturn(null);

        $stock->method('count')->willReturn(1);

        $strategy = new AiMoveStrategy($picker);
        $res = $strategy->createMove($board, $playerTiles, $stock);
        self::assertEquals(new PickStockMove($stock, $playerTiles), $res);
    }

    public function testCreateMoveSkip(): void
    {
        $board = $this->createBoard();
        $stock = $this->createTileSet();
        $playerTiles = $this->createTileSet();

        $picker = $this->createMoveTilePicker();
        $picker
            ->method('pickTileForLeftMove')
            ->with(self::identicalTo($board), self::identicalTo($playerTiles))
            ->willReturn(null);
        $picker
            ->method('pickTileForRightMove')
            ->with(self::identicalTo($board), self::identicalTo($playerTiles))
            ->willReturn(null);

        $stock->method('count')->willReturn(0);

        $strategy = new AiMoveStrategy($picker);
        $res = $strategy->createMove($board, $playerTiles, $stock);
        self::assertEquals(new SkipMove(), $res);
    }

    /**
     * @return Tile|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createTile()
    {
        return $this->createMock(Tile::class);
    }

    /**
     * @return TileSet|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createTileSet()
    {
        return $this->createMock(TileSet::class);
    }

    /**
     * @return Board|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createBoard()
    {
        return $this->createMock(Board::class);
    }

    /**
     * @return MoveTilePicker|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createMoveTilePicker()
    {
        return $this->createMock(MoveTilePicker::class);
    }
}
