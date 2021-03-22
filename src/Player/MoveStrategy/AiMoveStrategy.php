<?php

declare(strict_types=1);

namespace App\Player\MoveStrategy;

use App\Board\Board;
use App\Move\AddLeftMove;
use App\Move\AddRightMove;
use App\Move\MoveInterface;
use App\Move\PickStockMove;
use App\Move\SkipMove;
use App\Player\MoveStrategy\Ai\MoveTilePicker;
use App\Tile\TileSet;

class AiMoveStrategy implements MoveStrategyInterface
{
    /**
     * @var MoveTilePicker
     */
    private $moveTilePicker;

    /**
     * @param MoveTilePicker $moveTilePicker
     */
    public function __construct(MoveTilePicker $moveTilePicker)
    {
        $this->moveTilePicker = $moveTilePicker;
    }

    /**
     * {@inheritdoc}
     */
    public function createMove(Board $board, TileSet $playerTiles, TileSet $stock): MoveInterface
    {
        $leftMove = $this->moveTilePicker->pickTileForLeftMove($board, $playerTiles);
        if ($leftMove !== null) {
            return new AddLeftMove($board, $leftMove, $playerTiles);
        }

        $rightMove = $this->moveTilePicker->pickTileForRightMove($board, $playerTiles);
        if ($rightMove !== null) {
            return new AddRightMove($board, $rightMove, $playerTiles);
        }

        if (\count($stock) > 0) {
            return new PickStockMove($stock, $playerTiles);
        }

        return new SkipMove();
    }
}
