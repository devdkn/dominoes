<?php

declare(strict_types=1);

namespace AppTest\unit\Move\MoveResult;

use App\Move\MoveResult\MoveResultVisitorInterface;
use App\Move\MoveResult\PickStockResult;
use App\Player\PlayerInfoInterface;
use App\Tile\Tile;
use PHPUnit\Framework\TestCase;

class PickStockResultTest extends TestCase
{
    public function testInitialState(): void
    {
        $pickedTile = $this->createNotCallableTile();

        $result = new PickStockResult($pickedTile);
        self::assertSame($pickedTile, $result->getPickedTile());
    }

    public function testAccept(): void
    {
        $player = $this->createNotCallablePlayerInfoInterface();

        $result = new PickStockResult($this->createNotCallableTile());

        $visitor = $this->createMoveResultVisitorInterface();
        $visitor
            ->expects(self::once())
            ->method('visitPickStockResult')
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
     * @return Tile|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createNotCallableTile()
    {
        $mock = $this->createMock(Tile::class);
        $mock->expects(self::never())->method(self::anything());

        return $mock;
    }
}
