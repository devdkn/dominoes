<?php

declare(strict_types=1);

namespace AppTest\unit\Game\Stats;

use App\Game\Stats\StatsCalculator;
use App\Player\Player;
use App\Player\PlayersSet;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class StatsCalculatorTest extends TestCase
{
    public function testCalculateForBlockedBrokenEmptyPlayers(): void
    {
        $this->expectException(\LogicException::class);

        $player = $this->createPlayer();
        $players = $this->createPlayersSet();
        $players->method('current')->willReturn($player);
        $players->method('count')->willReturn(0);

        $calculator = new StatsCalculator();
        $calculator->calculateForBlocked($players);
    }

    public function testCalculateForBlocked(): void
    {
        $tiles1 = $this->createTileSet();
        $tiles1->method('sumValues')->willReturn(10);

        $player1 = $this->createPlayer();
        $player1->method('getPlayersTiles')->willReturn($tiles1);

        $tiles2 = $this->createTileSet();
        $tiles2->method('sumValues')->willReturn(9);

        $player2 = $this->createPlayer();
        $player2->method('getPlayersTiles')->willReturn($tiles2);

        $playersSet = $this->createPlayersSet();
        $playersSet->method('current')->willReturn($player1);
        $playersSet->method('next')->willReturn($player2);
        $playersSet->method('count')->willReturn(2);

        $calculator = new StatsCalculator();
        $res = $calculator->calculateForBlocked($playersSet);
        self::assertSame($player2, $res->getWinner());
        self::assertCount(2, $res->getItems());
    }

    public function testCalculateForWinner(): void
    {
        $winner = $this->createPlayer();
        $winner->expects(self::never())->method(self::anything());

        $tiles1 = $this->createTileSet();
        $tiles1->method('sumValues')->willReturn(10);

        $player1 = $this->createPlayer();
        $player1->method('getPlayersTiles')->willReturn($tiles1);

        $tiles2 = $this->createTileSet();
        $tiles2->method('sumValues')->willReturn(9);

        $player2 = $this->createPlayer();
        $player2->method('getPlayersTiles')->willReturn($tiles2);

        $playersSet = $this->createPlayersSet();
        $playersSet->method('current')->willReturn($player1);
        $playersSet->method('next')->willReturn($player2);
        $playersSet->method('count')->willReturn(2);

        $calculator = new StatsCalculator();
        $res = $calculator->calculateForWinner($winner, $playersSet);
        self::assertSame($winner, $res->getWinner());
        self::assertCount(2, $res->getItems());
    }

    private function createTileSet()
    {
        return $this->createMock(TileSet::class);
    }

    private function createPlayer()
    {
        return $this->createMock(Player::class);
    }

    private function createPlayersSet()
    {
        return $this->createMock(PlayersSet::class);
    }
}
