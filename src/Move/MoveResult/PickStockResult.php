<?php

declare(strict_types=1);

namespace App\Move\MoveResult;

use App\Player\PlayerInfoInterface;
use App\Tile\Tile;

class PickStockResult implements MoveResultInterface
{
    /**
     * @var Tile
     */
    private $pickedTile;

    /**
     * @param Tile $pickedTile
     */
    public function __construct(Tile $pickedTile)
    {
        $this->pickedTile = $pickedTile;
    }

    public function accept(PlayerInfoInterface $player, MoveResultVisitorInterface $visitor): void
    {
        $visitor->visitPickStockResult($player, $this);
    }

    /**
     * @return Tile
     */
    public function getPickedTile(): Tile
    {
        return $this->pickedTile;
    }
}
