<?php

declare(strict_types=1);

namespace App\Game;

use App\Board\Board;
use App\Game\Condition\EndGameConditionDetectorInterface;
use App\Game\EventHandler\GameEventHandlerInterface;
use App\Game\Hook\BetweenMovesHookInterface;
use App\Game\Stats\Stats;
use App\Game\Stats\StatsCalculatorInterface;
use App\Player\PlayersSet;
use App\Tile\TileSet;
use App\Util\LoopDetector;

class StartedGame
{
    /**
     * @var GameEventHandlerInterface
     */
    private $gameHandler;

    /**
     * @var StatsCalculatorInterface
     */
    private $statsCalculator;

    /**
     * @var EndGameConditionDetectorInterface
     */
    private $endGameConditionDetector;

    /**
     * @var Board
     */
    private $board;

    /**
     * @var PlayersSet
     */
    private $players;

    /**
     * @var TileSet
     */
    private $stock;

    /**
     * @param GameEventHandlerInterface         $gameHandler
     * @param StatsCalculatorInterface          $statsCalculator
     * @param EndGameConditionDetectorInterface $endGameConditionDetector
     * @param Board                             $board
     * @param PlayersSet                        $players
     * @param TileSet                           $stock
     */
    public function __construct(
        GameEventHandlerInterface $gameHandler,
        StatsCalculatorInterface $statsCalculator,
        EndGameConditionDetectorInterface $endGameConditionDetector,
        Board $board,
        PlayersSet $players,
        TileSet $stock
    ) {
        $this->gameHandler = $gameHandler;
        $this->statsCalculator = $statsCalculator;
        $this->endGameConditionDetector = $endGameConditionDetector;
        $this->board = $board;
        $this->players = $players;
        $this->stock = $stock;
    }

    /**
     * @param BetweenMovesHookInterface $betweenMovesHook
     *
     * @return Stats
     */
    public function run(BetweenMovesHookInterface $betweenMovesHook): Stats
    {
        $player = $this->players->current();

        $loopDetector = new LoopDetector();
        $playersNumber = $this->players->count();

        do {
            $move = $player->createMove($this->board, $this->stock);

            $moveResult = $move->execute();
            $this->gameHandler->handleMoveResult($player, $moveResult);

            if ($this->endGameConditionDetector->isWinner($player)) {
                $stats = $this->statsCalculator->calculateForWinner($player, $this->players);
                $this->gameHandler->handleGameEndWinner($stats);
                return $stats;
            }

            if ($this->endGameConditionDetector->isBlocked($this->board)) {
                $stats = $this->statsCalculator->calculateForBlocked($this->players);
                $this->gameHandler->handleGameEndBlocked($player, $stats);
                return $stats;
            }

            $loopDetector->detectLoopCondition($move, $playersNumber);

            if ($move->advancePlayer()) {
                $player = $this->players->next();
            }

            $betweenMovesHook->beforeNextMove();
        } while (true);
    }
}
