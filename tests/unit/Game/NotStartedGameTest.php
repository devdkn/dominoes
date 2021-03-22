<?php

declare(strict_types=1);

namespace AppTest\unit\Game;

use App\Board\Initializer\BoardInitializerInterface;
use App\Game\Condition\EndGameConditionDetectorInterface;
use App\Game\EventHandler\GameEventHandlerInterface;
use App\Game\NotStartedGame;
use App\Game\StartedGame;
use App\Game\Stats\StatsCalculatorInterface;
use App\Player\PlayersSet;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class NotStartedGameTest extends TestCase
{
    public function testStartGame(): void
    {
        $game = new NotStartedGame(
            $this->createGameEventHandlerInterface(),
            $this->createStatsCalculatorInterface(),
            $this->createEndGameConditionDetectorInterface(),
            $this->createPlayersSet(),
            $this->createTileSet(),
            $this->createBoardInitializerInterface()
        );
        $res = $game->start();
        self::assertInstanceOf(StartedGame::class, $res);
        self::assertSame($res, $game->start());
    }

    private function createGameEventHandlerInterface()
    {
        return $this->createMock(GameEventHandlerInterface::class);
    }

    private function createStatsCalculatorInterface()
    {
        return $this->createMock(StatsCalculatorInterface::class);
    }

    private function createEndGameConditionDetectorInterface()
    {
        return $this->createMock(EndGameConditionDetectorInterface::class);
    }

    private function createPlayersSet()
    {
        return $this->createMock(PlayersSet::class);
    }

    private function createTileSet()
    {
        return $this->createMock(TileSet::class);
    }

    private function createBoardInitializerInterface()
    {
        return $this->createMock(BoardInitializerInterface::class);
    }
}
