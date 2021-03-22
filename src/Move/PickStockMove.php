<?php

declare(strict_types=1);

namespace App\Move;

use App\Move\MoveResult\MoveResultInterface;
use App\Move\MoveResult\PickStockResult;
use App\Tile\TileSet;

class PickStockMove implements MoveInterface
{
    /**
     * @var TileSet
     */
    private $stock;

    /**
     * @var TileSet
     */
    private $playerTiles;

    /**
     * @param TileSet $stock
     * @param TileSet $playerTiles
     */
    public function __construct(TileSet $stock, TileSet $playerTiles)
    {
        $this->stock = $stock;
        $this->playerTiles = $playerTiles;
    }

    /**
     * {@inheritdoc}
     */
    public function advancePlayer(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): MoveResultInterface
    {
        $pickedTile = $this->stock->pop();
        if ($pickedTile === null) {
            throw new \LogicException('Can\'t pick a tile from the stock: the stock has no tiles.');
        }

        $this->playerTiles->add($pickedTile);

        return new PickStockResult($pickedTile);
    }
}
