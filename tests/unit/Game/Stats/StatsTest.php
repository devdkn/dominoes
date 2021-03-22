<?php

declare(strict_types=1);

namespace AppTest\unit\Game\Stats;

use App\Game\Stats\Stats;
use App\Game\Stats\StatsItem;
use App\Player\PlayerInfoInterface;
use PHPUnit\Framework\TestCase;

class StatsTest extends TestCase
{
    public function testInitialState(): void
    {
        $item1 = $this->createItem();
        $item2 = $this->createItem();

        $player = $this->createPlayerInfoInterface();

        $stats = new Stats($player, $item1, $item2);
        self::assertSame($player, $stats->getWinner());
        self::assertSame([$item1, $item2], $stats->getItems());
    }

    private function createPlayerInfoInterface()
    {
        return $this->createMock(PlayerInfoInterface::class);
    }

    private function createItem()
    {
        return $this->createMock(StatsItem::class);
    }
}
