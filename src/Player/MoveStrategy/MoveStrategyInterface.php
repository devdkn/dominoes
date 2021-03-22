<?php

declare(strict_types=1);

namespace App\Player\MoveStrategy;

use App\Board\Board;
use App\Move\MoveInterface;
use App\Tile\TileSet;

interface MoveStrategyInterface
{
    /**
     * @param Board   $board
     * @param TileSet $playerTiles
     * @param TileSet $stock
     *
     * @return MoveInterface
     */
    public function createMove(Board $board, TileSet $playerTiles, TileSet $stock): MoveInterface;
}
