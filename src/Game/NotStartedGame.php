<?php

declare(strict_types=1);

namespace App\Game;

use App\Board\Initializer\BoardInitializerInterface;
use App\Game\Condition\EndGameConditionDetectorInterface;
use App\Game\EventHandler\GameEventHandlerInterface;
use App\Game\Stats\StatsCalculatorInterface;
use App\Player\PlayersSet;
use App\Tile\TileSet;

class NotStartedGame
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
     * @var PlayersSet
     */
    private $players;

    /**
     * @var TileSet
     */
    private $stock;

    /**
     * @var BoardInitializerInterface
     */
    private $boardInitializer;

    /**
     * @var StartedGame|null
     */
    private $startedGame;

    /**
     * @param GameEventHandlerInterface         $gameHandler
     * @param StatsCalculatorInterface          $statsCalculator
     * @param EndGameConditionDetectorInterface $endGameConditionDetector
     * @param PlayersSet                        $playersSet
     * @param TileSet                           $stock
     * @param BoardInitializerInterface         $boardInitializer
     */
    public function __construct(
        GameEventHandlerInterface $gameHandler,
        StatsCalculatorInterface $statsCalculator,
        EndGameConditionDetectorInterface $endGameConditionDetector,
        PlayersSet $playersSet,
        TileSet $stock,
        BoardInitializerInterface $boardInitializer
    ) {
        $this->gameHandler = $gameHandler;
        $this->statsCalculator = $statsCalculator;
        $this->endGameConditionDetector = $endGameConditionDetector;
        $this->players = $playersSet;
        $this->stock = $stock;
        $this->boardInitializer = $boardInitializer;
    }

    /**
     * @return StartedGame
     */
    public function start(): StartedGame
    {
        if ($this->startedGame === null) {
            $this->startedGame = new StartedGame(
                $this->gameHandler,
                $this->statsCalculator,
                $this->endGameConditionDetector,
                $this->boardInitializer->initialize($this->stock, $this->players),
                $this->players,
                $this->stock
            );
        }

        return $this->startedGame;
    }
}
