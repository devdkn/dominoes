<?php

declare(strict_types=1);

namespace App\Board\Initializer;

use App\Board\Board;
use App\Board\BoardFactory;
use App\Board\Initializer\EventHandler\BoardEventHandlerInterface;
use App\Player\PlayersSet;
use App\Tile\TileSet;

class StockInitializer implements BoardInitializerInterface
{
    /**
     * @var BoardFactory
     */
    private $boardFactory;

    /**
     * @var BoardEventHandlerInterface
     */
    private $handler;

    /**
     * @param BoardFactory               $boardFactory
     * @param BoardEventHandlerInterface $handler
     */
    public function __construct(BoardFactory $boardFactory, BoardEventHandlerInterface $handler)
    {
        $this->boardFactory = $boardFactory;
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(TileSet $stock, PlayersSet $players): Board
    {
        $tile = $stock->pop();
        if ($tile === null) {
            throw new \LogicException('Failed to initialize the board: stock has no tiles.');
        }

        $board = $this->boardFactory->createBoard($tile);

        $this->handler->onBoardInitializedFromStock($board);

        return $board;
    }
}
