<?php

declare(strict_types=1);

namespace App\TileProvider;

use App\Tile\TileSet;

class ShuffleProvider implements TileProviderInterface
{
    /**
     * @var TileProviderInterface
     */
    private $tileProvider;

    /**
     * @param TileProviderInterface $tileProvider
     */
    public function __construct(TileProviderInterface $tileProvider)
    {
        $this->tileProvider = $tileProvider;
    }

    /**
     * @param int $uniqueValuesPerTileSide
     *
     * @return TileSet
     */
    public function provideTiles(int $uniqueValuesPerTileSide): TileSet
    {
        $initialSet = $this->tileProvider->provideTiles($uniqueValuesPerTileSide);

        $tiles = [];
        while (($tile = $initialSet->pop()) !== null) {
            $tiles[] = $tile;
        }
        \shuffle($tiles);

        $resultSet = new TileSet();
        foreach ($tiles as $tile) {
            $resultSet->add($tile);
        }

        return $resultSet;
    }
}
