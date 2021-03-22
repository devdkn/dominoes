<?php

declare(strict_types=1);

namespace App\Player;

use App\Tile\TileSet;

interface PlayerInfoInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return TileSet
     */
    public function getPlayersTiles(): TileSet;
}
