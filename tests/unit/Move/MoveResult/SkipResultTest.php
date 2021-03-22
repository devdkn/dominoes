<?php

declare(strict_types=1);

namespace AppTest\unit\Move\MoveResult;

use App\Move\MoveResult\MoveResultVisitorInterface;

use App\Move\MoveResult\SkipResult;
use App\Player\PlayerInfoInterface;
use PHPUnit\Framework\TestCase;

class SkipResultTest extends TestCase
{
    public function testAccept(): void
    {
        $player = $this->createNotCallablePlayerInfoInterface();

        $result = new SkipResult();

        $visitor = $this->createMoveResultVisitorInterface();
        $visitor
            ->expects(self::once())
            ->method('visitSkipResult')
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
}
