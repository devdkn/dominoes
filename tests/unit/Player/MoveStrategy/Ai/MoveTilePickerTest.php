<?php

declare(strict_types=1);

namespace AppTest\unit\Player\MoveStrategy\Ai;

use App\Board\Board;
use App\Player\MoveStrategy\Ai\MoveTilePicker;
use App\Tile\Tile;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class MoveTilePickerTest extends TestCase
{
    public function testPickTileForLeftMoveNoMoves(): void
    {
        $leftValue = 1;

        $board = $this->createBoard();
        $board->method('getLeftValue')->willReturn($leftValue);

        $filteredSet = $this->createTileSet();
        $filteredSet->method('count')->willReturn(0);

        $collection = $this->createTileSet();
        $collection->method('filterByValue')->with($leftValue)->willReturn($filteredSet);

        $picker = new MoveTilePicker();
        $res = $picker->pickTileForLeftMove($board, $collection);
        self::assertNull($res);
    }

    public function testPickTileForLeftMoveTilePopError(): void
    {
        $this->expectException(\LogicException::class);

        $leftValue = 1;

        $board = $this->createBoard();
        $board->method('getLeftValue')->willReturn($leftValue);

        $filteredSet = $this->createTileSet();
        $filteredSet->method('count')->willReturn(1);
        $filteredSet->method('pop')->willReturn(null);

        $collection = $this->createTileSet();
        $collection->method('filterByValue')->with($leftValue)->willReturn($filteredSet);

        $picker = new MoveTilePicker();
        $picker->pickTileForLeftMove($board, $collection);
    }

    public function testPickTileForLeftMoveCorrect(): void
    {
        $leftValue = 1;

        $board = $this->createBoard();
        $board->method('getLeftValue')->willReturn($leftValue);

        $tile = $this->createTile();
        $tile->method('getRight')->willReturn($leftValue);

        $filteredSet = $this->createTileSet();
        $filteredSet->method('count')->willReturn(1);
        $filteredSet->method('pop')->willReturn($tile);

        $collection = $this->createTileSet();
        $collection->method('filterByValue')->with($leftValue)->willReturn($filteredSet);

        $picker = new MoveTilePicker();
        $res = $picker->pickTileForLeftMove($board, $collection);
        self::assertSame($tile, $res);
    }

    public function testPickTileForLeftMoveFlip(): void
    {
        $leftValue = 1;
        $otherValue = 2;

        $board = $this->createBoard();
        $board->method('getLeftValue')->willReturn($leftValue);

        $flippedTile = $this->createTile();
        $flippedTile->expects(self::never())->method(self::anything());

        $tile = $this->createTile();
        $tile->method('getRight')->willReturn($otherValue);
        $tile->method('flip')->willReturn($flippedTile);

        $filteredSet = $this->createTileSet();
        $filteredSet->method('count')->willReturn(1);
        $filteredSet->method('pop')->willReturn($tile);

        $collection = $this->createTileSet();
        $collection->method('filterByValue')->with($leftValue)->willReturn($filteredSet);

        $picker = new MoveTilePicker();
        $res = $picker->pickTileForLeftMove($board, $collection);
        self::assertSame($flippedTile, $res);
    }

    public function testPickTileForRightMoveNoMoves(): void
    {
        $rightValue = 1;

        $board = $this->createBoard();
        $board->method('getRightValue')->willReturn($rightValue);

        $filteredSet = $this->createTileSet();
        $filteredSet->method('count')->willReturn(0);

        $collection = $this->createTileSet();
        $collection->method('filterByValue')->with($rightValue)->willReturn($filteredSet);

        $picker = new MoveTilePicker();
        $res = $picker->pickTileForRightMove($board, $collection);
        self::assertNull($res);
    }

    public function testPickTileForRightMoveTilePopError(): void
    {
        $this->expectException(\LogicException::class);

        $rightValue = 1;

        $board = $this->createBoard();
        $board->method('getRightValue')->willReturn($rightValue);

        $filteredSet = $this->createTileSet();
        $filteredSet->method('count')->willReturn(1);
        $filteredSet->method('pop')->willReturn(null);

        $collection = $this->createTileSet();
        $collection->method('filterByValue')->with($rightValue)->willReturn($filteredSet);

        $picker = new MoveTilePicker();
        $picker->pickTileForRightMove($board, $collection);
    }

    public function testPickTileForRightMoveCorrect(): void
    {
        $rightValue = 1;

        $board = $this->createBoard();
        $board->method('getRightValue')->willReturn($rightValue);

        $tile = $this->createTile();
        $tile->method('getLeft')->willReturn($rightValue);

        $filteredSet = $this->createTileSet();
        $filteredSet->method('count')->willReturn(1);
        $filteredSet->method('pop')->willReturn($tile);

        $collection = $this->createTileSet();
        $collection->method('filterByValue')->with($rightValue)->willReturn($filteredSet);

        $picker = new MoveTilePicker();
        $res = $picker->pickTileForRightMove($board, $collection);
        self::assertSame($tile, $res);
    }

    public function testPickTileForRightMoveFlip(): void
    {
        $rightValue = 1;
        $otherValue = 2;

        $board = $this->createBoard();
        $board->method('getRightValue')->willReturn($rightValue);

        $flippedTile = $this->createTile();
        $flippedTile->expects(self::never())->method(self::anything());

        $tile = $this->createTile();
        $tile->method('getLeft')->willReturn($otherValue);
        $tile->method('flip')->willReturn($flippedTile);

        $filteredSet = $this->createTileSet();
        $filteredSet->method('count')->willReturn(1);
        $filteredSet->method('pop')->willReturn($tile);

        $collection = $this->createTileSet();
        $collection->method('filterByValue')->with($rightValue)->willReturn($filteredSet);

        $picker = new MoveTilePicker();
        $res = $picker->pickTileForRightMove($board, $collection);
        self::assertSame($flippedTile, $res);
    }

    private function createBoard()
    {
        return $this->createMock(Board::class);
    }

    private function createTileSet()
    {
        return $this->createMock(TileSet::class);
    }

    private function createTile()
    {
        return $this->createMock(Tile::class);
    }
}
