<?php

declare(strict_types=1);

namespace App\Board\Initializer;

use App\Board;
use App\Board\Initializer\EventHandler\BoardEventHandlerInterface;
use App\Player\PlayersSet;
use App\Tile\TileSet;
use App\Util\NumberGenerator;

class RandomPlayerTileInitializer implements BoardInitializerInterface
{
    /**
     * @var Board\BoardFactory
     */
    private $boardFactory;

    /**
     * @var NumberGenerator
     */
    private $numberGenerator;

    /**
     * @var BoardEventHandlerInterface
     */
    private $handler;

    /**
     * @param Board\BoardFactory         $boardFactory
     * @param NumberGenerator            $numberGenerator
     * @param BoardEventHandlerInterface $handler
     */
    public function __construct(
        Board\BoardFactory $boardFactory,
        NumberGenerator $numberGenerator,
        BoardEventHandlerInterface $handler
    ) {
        $this->boardFactory = $boardFactory;
        $this->numberGenerator = $numberGenerator;
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(TileSet $stock, PlayersSet $players): Board\Board
    {
        $player = $this->numberGenerator->randomNumber(0, 1) === 0 ? $players->current() : $players->next();
        $tile = $player->getPlayersTiles()->pop();
        if ($tile === null) {
            throw new \LogicException(
                'Failed to initialize the board: player ' . $player->getName() . ' has no tiles.'
            );
        }

        $board = $this->boardFactory->createBoard($tile);

        // next move should be taken by the next player.
        $players->next();

        $this->handler->onBoardInitializedByPlayer($board, $player);

        return $board;
    }
}
