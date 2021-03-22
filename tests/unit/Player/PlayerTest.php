<?php

declare(strict_types=1);

namespace AppTest\unit\Player;

use App\Board\Board;
use App\Move\MoveInterface;
use App\Player\MoveStrategy\MoveStrategyInterface;
use App\Player\Player;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testInitialState(): void
    {
        $tiles = $this->createTileSet();
        $player = new Player('name-1', $tiles, $this->createMoveStrategyInterface());
        self::assertSame('name-1', $player->getName());
        self::assertSame($tiles, $player->getPlayersTiles());
    }

    public function testCreateMove(): void
    {
        $res = $this->createMoveInterface();

        $tiles = $this->createTileSet();
        $stock = $this->createTileSet();

        $board = $this->createBoard();

        $moveStrategy = $this->createMoveStrategyInterface();
        $moveStrategy
            ->method('createMove')
            ->with(
                self::identicalTo($board),
                self::identicalTo($tiles),
                self::identicalTo($stock)
            )
            ->willReturn($res);

        $player = new Player('name', $tiles, $moveStrategy);
        self::assertSame($res, $player->createMove($board, $stock));
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|MoveInterface
     */
    private function createMoveInterface()
    {
        return $this->getMockBuilder(MoveInterface::class)->getMockForAbstractClass();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|Board
     */
    private function createBoard()
    {
        return $this->getMockBuilder(Board::class)->disableOriginalConstructor()->disableProxyingToOriginalMethods()->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|TileSet
     */
    private function createTileSet()
    {
        return $this->getMockBuilder(TileSet::class)->disableOriginalConstructor()->disableProxyingToOriginalMethods()->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|MoveStrategyInterface
     */
    private function createMoveStrategyInterface()
    {
        return $this->getMockBuilder(MoveStrategyInterface::class)->getMockForAbstractClass();
    }
}
