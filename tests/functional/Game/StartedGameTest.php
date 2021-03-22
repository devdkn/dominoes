<?php

declare(strict_types=1);

namespace AppTest\functional\Game;

use App\Board\Board;
use App\Game\Condition\EndGameConditionDetector;
use App\Game\Hook\BetweenMovesDelayHook;
use App\Game\StartedGame;
use App\Game\Stats\StatsCalculator;
use App\Player\MoveStrategy\Ai\MoveTilePicker;
use App\Player\MoveStrategy\AiMoveStrategy;
use App\Player\Player;
use App\Player\PlayersSet;
use App\Tile\Tile;
use App\Tile\TileSet;
use App\Util\DelayService;
use AppTest\functional\Game\Stub\GameEventHandlerStub;
use PHPUnit\Framework\TestCase;

class StartedGameTest extends TestCase
{
    public function test2PlayerAiGameBlocked(): void
    {
        $stock = new TileSet();
        for ($left = 0; $left < 7; ++$left) {
            for ($right = $left; $right < 7; ++$right) {
                $stock->add(new Tile($left, $right));
            }
        }

        $player1Tiles = new TileSet();
        $player1Tiles->add(new Tile(2, 2));
        $stock->remove(new Tile(2, 2));
        $player1Tiles->add(new Tile(2, 3));
        $stock->remove(new Tile(2, 3));
        $player1Tiles->add(new Tile(2, 4));
        $stock->remove(new Tile(2, 4));
        $player1Tiles->add(new Tile(2, 5));
        $stock->remove(new Tile(2, 5));
        $player1 = new Player('player1', $player1Tiles, new AiMoveStrategy(new MoveTilePicker()));

        $player2Tiles = new TileSet();
        $player2Tiles->add(new Tile(3, 3));
        $stock->remove(new Tile(3, 3));
        $player2Tiles->add(new Tile(3, 4));
        $stock->remove(new Tile(3, 4));
        $player2Tiles->add(new Tile(3, 5));
        $stock->remove(new Tile(3, 5));
        $player2Tiles->add(new Tile(3, 6));
        $stock->remove(new Tile(3, 6));
        $player2 = new Player('player2', $player2Tiles, new AiMoveStrategy(new MoveTilePicker()));

        $stock->remove(new Tile(1, 5));
        $players = new PlayersSet($player1, $player2);
        $game = new StartedGame(
            new GameEventHandlerStub(),
            new StatsCalculator(),
            new EndGameConditionDetector(7),
            new Board(new Tile(1, 5)),
            $players,
            $stock
        );

        $res = $game->run(new BetweenMovesDelayHook(new DelayService(), 0));
        self::assertSame($player1, $res->getWinner());
        self::assertCount(2, $res->getItems());
        self::assertSame($player2, $res->getItems()[0]->getPlayerInfo());
        self::assertSame(26, $res->getItems()[0]->getSum());
        self::assertSame($player1, $res->getItems()[1]->getPlayerInfo());
        self::assertSame(4, $res->getItems()[1]->getSum());
    }

    public function test2PlayerAiGameWinner(): void
    {
        $stock = new TileSet();
        for ($left = 0; $left < 7; ++$left) {
            for ($right = $left; $right < 7; ++$right) {
                $stock->add(new Tile($left, $right));
            }
        }

        $player1Tiles = new TileSet();
        $player1Tiles->add(new Tile(2, 2));
        $stock->remove(new Tile(2, 2));
        $player1Tiles->add(new Tile(2, 3));
        $stock->remove(new Tile(2, 3));
        $player1Tiles->add(new Tile(2, 4));
        $stock->remove(new Tile(2, 4));
        $player1 = new Player('player1', $player1Tiles, new AiMoveStrategy(new MoveTilePicker()));

        $player2Tiles = new TileSet();
        $player2Tiles->add(new Tile(3, 3));
        $stock->remove(new Tile(3, 3));
        $player2Tiles->add(new Tile(3, 6));
        $stock->remove(new Tile(3, 6));
        $player2Tiles->add(new Tile(2, 5));
        $stock->remove(new Tile(2, 5));
        $player2 = new Player('player2', $player2Tiles, new AiMoveStrategy(new MoveTilePicker()));

        $stock->remove(new Tile(4, 5));
        $players = new PlayersSet($player1, $player2);
        $game = new StartedGame(
            new GameEventHandlerStub(),
            new StatsCalculator(),
            new EndGameConditionDetector(7),
            new Board(new Tile(4, 5)),
            $players,
            $stock
        );
        $res = $game->run(new BetweenMovesDelayHook(new DelayService(), 0));
        self::assertSame($player2, $res->getWinner());
        self::assertCount(2, $res->getItems());
        self::assertSame($player2, $res->getItems()[0]->getPlayerInfo());
        self::assertSame(0, $res->getItems()[0]->getSum());
        self::assertSame($player1, $res->getItems()[1]->getPlayerInfo());
        self::assertSame(41, $res->getItems()[1]->getSum());
    }
}
