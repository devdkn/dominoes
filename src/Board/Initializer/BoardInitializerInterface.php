<?php

declare(strict_types=1);

namespace App\Board\Initializer;

use App\Board\Board;
use App\Player\PlayersSet;
use App\Tile\TileSet;

interface BoardInitializerInterface
{
    /**
     * @param TileSet    $stock
     * @param PlayersSet $players
     *
     * @return Board
     */
    public function initialize(TileSet $stock, PlayersSet $players): Board;
}
