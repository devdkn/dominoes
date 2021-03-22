<?php

declare(strict_types=1);

namespace App\Move;

use App\Board\Board;
use App\Move\MoveResult\AddLeftResult;
use App\Move\MoveResult\MoveResultInterface;
use App\Tile\Tile;
use App\Tile\TileSet;

class AddLeftMove implements MoveInterface
{
    /**
     * @var Board
     */
    private $board;

    /**
     * @var Tile
     */
    private $tile;

    /**
     * @var TileSet
     */
    private $playerTiles;

    /**
     * @param Board   $board
     * @param Tile    $tile
     * @param TileSet $playerTiles
     */
    public function __construct(Board $board, Tile $tile, TileSet $playerTiles)
    {
        $this->board = $board;
        $this->tile = $tile;
        $this->playerTiles = $playerTiles;
    }

    /**
     * {@inheritdoc}
     */
    public function advancePlayer(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): MoveResultInterface
    {
        $this->playerTiles->remove($this->tile);

        $oldLeft = $this->board->getLeft();
        $this->board->addLeft($this->tile);

        return new AddLeftResult($this->board, $oldLeft);
    }
}
