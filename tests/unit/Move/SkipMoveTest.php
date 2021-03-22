<?php

declare(strict_types=1);

namespace AppTest\unit\Move;

use App\Move\MoveResult\SkipResult;
use App\Move\SkipMove;
use PHPUnit\Framework\TestCase;

class SkipMoveTest extends TestCase
{
    public function testInitialState(): void
    {
        $move = new SkipMove();
        self::assertTrue($move->advancePlayer());
    }

    public function testExecute(): void
    {
        $move = new SkipMove();
        $res = $move->execute();
        self::assertEquals(new SkipResult(), $res);
    }
}
