<?php

declare(strict_types=1);

namespace AppTest\unit\Player;

use App\Player\Player;
use App\Player\PlayersSet;
use PHPUnit\Framework\TestCase;

class PlayerSetTest extends TestCase
{
    public function testCount(): void
    {
        $player1 = $this->createPlayer();
        $player2 = $this->createPlayer();
        $player3 = $this->createPlayer();

        $set = new PlayersSet($player1, $player2, $player3);
        self::assertCount(3, $set);
    }

    public function testIteration(): void
    {
        $player1 = $this->createPlayer();
        $player2 = $this->createPlayer();
        $player3 = $this->createPlayer();

        $set = new PlayersSet($player1, $player2, $player3);
        self::assertSame($player1, $set->current());
        self::assertSame($player2, $set->next());
        self::assertSame($player2, $set->current());
        self::assertSame($player3, $set->next());
        self::assertSame($player1, $set->next());
    }

    /**
     * @return Player|\PHPUnit\Framework\MockObject\MockObject
     */
    private function createPlayer()
    {
        $mock = $this->createMock(Player::class);
        $mock->expects(self::never())->method(self::anything());
        return $mock;
    }
}
