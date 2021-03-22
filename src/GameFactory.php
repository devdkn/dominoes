<?php

declare(strict_types=1);

namespace App;

use App\Board\Initializer\BoardInitializerFactory;
use App\EventHandler\EventHandlerInterface;
use App\Game\Condition\GameConditionFactory;
use App\Game\NotStartedGame;
use App\Game\Stats\StatsCalculatorFactory;
use App\Player\MoveStrategy\MoveStrategyFactory;
use App\Player\PlayerSetFactory;
use App\TileProvider\TileProviderInterface;

class GameFactory
{
    private const CLASSIC_GAME_UNIQUE_VALUES_PER_TILE_SIDE = 7;
    private const CLASSIC_GAME_TILES_PER_2_PLAYERS = 7;

    /**
     * @var TileProviderInterface
     */
    private $tileProvider;

    /**
     * @var PlayerSetFactory
     */
    private $playerSetFactory;

    /**
     * @var BoardInitializerFactory
     */
    private $boardInitializerFactory;

    /**
     * @var MoveStrategyFactory
     */
    private $moveStrategyFactory;

    /**
     * @var StatsCalculatorFactory
     */
    private $statsCalculatorFactory;

    /**
     * @var GameConditionFactory
     */
    private $gameConditionFactory;

    /**
     * @param TileProviderInterface   $tileProvider
     * @param PlayerSetFactory        $playerSetFactory
     * @param BoardInitializerFactory $boardInitializerFactory
     * @param MoveStrategyFactory     $moveStrategyFactory
     * @param StatsCalculatorFactory  $statsCalculatorFactory
     * @param GameConditionFactory    $gameConditionFactory
     */
    public function __construct(
        TileProviderInterface $tileProvider,
        PlayerSetFactory $playerSetFactory,
        BoardInitializerFactory $boardInitializerFactory,
        MoveStrategyFactory $moveStrategyFactory,
        StatsCalculatorFactory $statsCalculatorFactory,
        GameConditionFactory $gameConditionFactory
    ) {
        $this->tileProvider = $tileProvider;
        $this->playerSetFactory = $playerSetFactory;
        $this->boardInitializerFactory = $boardInitializerFactory;
        $this->moveStrategyFactory = $moveStrategyFactory;
        $this->statsCalculatorFactory = $statsCalculatorFactory;
        $this->gameConditionFactory = $gameConditionFactory;
    }

    /**
     * @param EventHandlerInterface $eventHandler
     * @param string                $player1Name
     * @param string                $player2Name
     *
     * @return NotStartedGame
     *
     * @throws \UnexpectedValueException
     */
    public function createClassicAiGame(EventHandlerInterface $eventHandler, string $player1Name, string $player2Name): NotStartedGame
    {
        if ($player1Name === $player2Name) {
            throw new \UnexpectedValueException('Players can\'t have same names.');
        }

        $stock = $this->tileProvider->provideTiles(self::CLASSIC_GAME_UNIQUE_VALUES_PER_TILE_SIDE);

        $aiStrategy = $this->moveStrategyFactory->createAiMoveStrategy();

        $playersSet = $this->playerSetFactory->createPlayersSet(
            $stock,
            self::CLASSIC_GAME_TILES_PER_2_PLAYERS,
            $this->playerSetFactory->createDto($player1Name, $aiStrategy),
            $this->playerSetFactory->createDto($player2Name, $aiStrategy),
        );

        $boardInitializer = $this->boardInitializerFactory->createRandomPlayerTile($eventHandler);

        return new NotStartedGame(
            $eventHandler,
            $this->statsCalculatorFactory->createCalculator(),
            $this->gameConditionFactory->createEndGameConditionDetector(self::CLASSIC_GAME_UNIQUE_VALUES_PER_TILE_SIDE),
            $playersSet,
            $stock,
            $boardInitializer
        );
    }
}
