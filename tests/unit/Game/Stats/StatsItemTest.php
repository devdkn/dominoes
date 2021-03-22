<?php

declare(strict_types=1);

namespace AppTest\unit\Game\Stats;

use App\Game\Stats\StatsItem;
use App\Player\PlayerInfoInterface;
use PHPUnit\Framework\TestCase;

class StatsItemTest extends TestCase
{
    public function testInitialState(): void
    {
        $player = $this->createPlayerInfoInterface();
        $item = new StatsItem($player, 3);
        self::assertSame($player, $item->getPlayerInfo());
        self::assertSame(3, $item->getSum());
    }

    private function createPlayerInfoInterface()
    {
        return $this->createMock(PlayerInfoInterface::class);
    }
}
