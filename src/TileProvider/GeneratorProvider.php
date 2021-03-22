<?php

declare(strict_types=1);

namespace App\TileProvider;

use App\Tile\TileSet;
use App\Tile\Tile;

class GeneratorProvider implements TileProviderInterface
{
    /**
     * @param int $uniqueValuesPerTileSide
     *
     * @return TileSet
     */
    public function provideTiles(int $uniqueValuesPerTileSide): TileSet
    {
        if ($uniqueValuesPerTileSide < 1) {
            throw new \LogicException('$uniqueValuesPerTileSide cannot be less than 1');
        }
        $collection = new TileSet();

        for ($left = 0; $left < $uniqueValuesPerTileSide; ++$left) {
            for ($right = $left; $right < $uniqueValuesPerTileSide; ++$right) {
                $collection->add(new Tile($left, $right));
            }
        }

        return $collection;
    }
}
