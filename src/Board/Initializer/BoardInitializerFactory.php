<?php

declare(strict_types=1);

namespace App\Board\Initializer;

use App\Board\BoardFactory;
use App\Board\Initializer\EventHandler\BoardEventHandlerInterface;
use App\Util\NumberGenerator;

class BoardInitializerFactory
{
    /**
     * @param BoardEventHandlerInterface $handler
     *
     * @return RandomPlayerTileInitializer
     */
    public function createRandomPlayerTile(BoardEventHandlerInterface $handler): RandomPlayerTileInitializer
    {
        return new RandomPlayerTileInitializer(new BoardFactory(), new NumberGenerator(), $handler);
    }

    /**
     * @param BoardEventHandlerInterface $handler
     *
     * @return StockInitializer
     */
    public function createStockInitializer(BoardEventHandlerInterface $handler): StockInitializer
    {
        return new StockInitializer(new BoardFactory(), $handler);
    }
}
