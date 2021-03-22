<?php

declare(strict_types=1);

namespace AppTest\unit\Move\MoveResult;

use App\Board\Board;
use App\Move\MoveResult\AddRightResult;
use App\Move\MoveResult\MoveResultVisitorInterface;
use App\Player\PlayerInfoInterface;
use App\Tile\Tile;
use PHPUnit\Framework\TestCase;

class AddRightResultTest extends TestCase
{
    public function testInitialState(): void
    {
        $board = $this->createNotCallableBoard();
        $oldRight = $this->createNotCallableTile();

        $result = new AddRightResult($board, $oldRight);
        self::assertSame($board, $result->getBoard());
        self::assertSame($oldRight, $result->getOldRight());
    }

    public function testAccept(): void
    {
        $player = $this->createNotCallablePlayerInfoInterface();

        $result = new AddRightResult($this->createNotCallableBoard(), $this->createNotCallableTile());

        $visitor = $this->createMoveResultVisitorInterface();
        $visitor
            ->expects(self::once())
            ->method('visitAddRightResult')
            ->with(self::identicalTo($player), self::identicalTo($result));

        $result->accept($player, $visitor);
    }

    /**
     * @return MoveResultVisitorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createMoveResultVisitorInterface()
    {
        return $this->createMock(MoveResultVisitorInterface::class);
    }

    /**
     * @return PlayerInfoInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createNotCallablePlayerInfoInterface()
    {
        $mock = $this->createMock(PlayerInfoInterface::class);
        $mock->expects(self::never())->method(self::anything());

        return $mock;
    }

    /**
     * @return Board|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createNotCallableBoard()
    {
        $mock = $this->createMock(Board::class);
        $mock->expects(self::never())->method(self::anything());

        return $mock;
    }

    /**
     * @return Tile|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createNotCallableTile()
    {
        $mock = $this->createMock(Tile::class);
        $mock->expects(self::never())->method(self::anything());

        return $mock;
    }
}
