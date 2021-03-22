<?php

declare(strict_types=1);

namespace AppTest\unit\Board\Initializer;

use App\Board\Board;
use App\Board\BoardFactory;
use App\Board\Initializer\EventHandler\BoardEventHandlerInterface;
use App\Board\Initializer\StockInitializer;
use App\Player\PlayersSet;
use App\Tile\Tile;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class StockInitializerTest extends TestCase
{
    public function testInitializeWithEmptyStock(): void
    {
        $this->expectException(\LogicException::class);

        $eventHandler = $this->createBoardEventHandlerInterface();
        $eventHandler->expects(self::never())->method(self::anything());

        $stock = $this->createTileSet();
        $stock->method('pop')->willReturn(null);

        $players = $this->createPlayersSet();
        $players->expects(self::never())->method(self::anything());

        $factory = $this->createBoardFactory();
        $factory->expects(self::never())->method(self::anything());

        $initializer = new StockInitializer($factory, $eventHandler);
        $initializer->initialize($stock, $players);
    }

    public function testInitialize(): void
    {
        $tile = $this->createTile();

        $stock = $this->createTileSet();
        $stock->method('pop')->willReturn($tile);

        $board = $this->createBoard();
        $factory = $this->createBoardFactory();
        $factory->method('createBoard')->with(self::identicalTo($tile))->willReturn($board);

        $eventHandler = $this->createBoardEventHandlerInterface();
        $eventHandler
            ->expects(self::once())
            ->method('onBoardInitializedFromStock')
            ->with(self::identicalTo($board));

        $initializer = new StockInitializer($factory, $eventHandler);
        self::assertSame($board, $initializer->initialize($stock, $this->createPlayersSet()));
    }

    private function createBoardFactory()
    {
        return $this->createMock(BoardFactory::class);
    }

    private function createBoard()
    {
        return $this->createMock(Board::class);
    }

    private function createTile()
    {
        return $this->createMock(Tile::class);
    }

    private function createPlayersSet()
    {
        return $this->createMock(PlayersSet::class);
    }

    private function createTileSet()
    {
        return $this->createMock(TileSet::class);
    }

    private function createBoardEventHandlerInterface()
    {
        return $this->createMock(BoardEventHandlerInterface::class);
    }
}
