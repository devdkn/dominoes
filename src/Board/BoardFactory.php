<?php

declare(strict_types=1);

namespace App\Board;

use App\Tile\Tile;

class BoardFactory
{
    /**
     * @param Tile $tile
     *
     * @return Board
     */
    public function createBoard(Tile $tile): Board
    {
        return new Board($tile);
    }
}
