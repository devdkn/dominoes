<?php

declare(strict_types=1);

namespace App\TileProvider;

use App\Tile\TileSet;

interface TileProviderInterface
{
    /**
     * @param int $uniqueValuesPerTileSide
     *
     * @return TileSet
     */
    public function provideTiles(int $uniqueValuesPerTileSide): TileSet;
}
