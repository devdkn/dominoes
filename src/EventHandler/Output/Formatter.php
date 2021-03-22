<?php

declare(strict_types=1);

namespace App\EventHandler\Output;

use App\Player\PlayerInfoInterface;
use App\Tile\Tile;

class Formatter
{
    /**
     * @param PlayerInfoInterface $playerInfo
     *
     * @return string
     */
    public function formatPlayer(PlayerInfoInterface $playerInfo): string
    {
        return $playerInfo->getName() . ' (' . \count($playerInfo->getPlayersTiles()) . ')';
    }

    /**
     * @param Tile $tile
     *
     * @return string
     */
    public function formatTile(Tile $tile): string
    {
        return '<' . (string) $tile . '>';
    }

    /**
     * @param Tile ...$tiles
     *
     * @return string
     */
    public function formatTiles(Tile ...$tiles): string
    {
        $res = [];
        foreach ($tiles as $tile) {
            $res[] = $this->formatTile($tile);
        }

        return \implode(' ', $res);
    }
}
