<?php

declare(strict_types=1);

namespace AppTest\unit\Board\Initializer;

use App\Board\Initializer\BoardInitializerFactory;
use App\Board\Initializer\EventHandler\BoardEventHandlerInterface;
use App\Board\Initializer\RandomPlayerTileInitializer;
use App\Board\Initializer\StockInitializer;
use PHPUnit\Framework\TestCase;

class BoardInitializerFactoryTest extends TestCase
{
    public function testCreateRandomPlayerTile(): void
    {
        $factory = new BoardInitializerFactory();
        $res = $factory->createRandomPlayerTile($this->createBoardEventHandlerInterface());
        self::assertInstanceOf(RandomPlayerTileInitializer::class, $res);
    }

    public function testCreateStockInitializer(): void
    {
        $factory = new BoardInitializerFactory();
        $res = $factory->createStockInitializer($this->createBoardEventHandlerInterface());
        self::assertInstanceOf(StockInitializer::class, $res);
    }

    private function createBoardEventHandlerInterface()
    {
        return $this->createMock(BoardEventHandlerInterface::class);
    }
}
