<?php

declare(strict_types=1);

namespace AppTest\unit\Player;

use App\Player\MoveStrategy\MoveStrategyInterface;
use App\Player\Player;
use App\Player\PlayerDto;
use App\Player\PlayerSetFactory;
use App\Player\PlayersSet;
use App\Tile\TileSet;
use PHPUnit\Framework\TestCase;

class PlayerSetFactoryTest extends TestCase
{
    public function testCreateDto(): void
    {
        $strategy = $this->createMoveStrategyInterface();
        $factory = new PlayerSetFactory();
        $dto = $factory->createDto('name-1', $strategy);
        self::assertSame('name-1', $dto->getName());
        self::assertSame($strategy, $dto->getStrategy());
    }

    public function testCreate2PlayersWithException(): void
    {
        $this->expectException(\LogicException::class);

        $tilesPerPlayer = 7;

        $tileSetCorrect = $this->createTileSet();
        $tileSetCorrect->method('count')->willReturn($tilesPerPlayer);

        $tileSetIncorrect = $this->createTileSet();
        $tileSetIncorrect->method('count')->willReturn($tilesPerPlayer + 1);

        $stock = $this->createTileSet();
        $stock->method('popN')->with($tilesPerPlayer)->willReturnOnConsecutiveCalls($tileSetCorrect, $tileSetIncorrect);

        $factory = new PlayerSetFactory();
        $factory->createPlayersSet(
            $stock,
            $tilesPerPlayer,
            new PlayerDto('name-1', $this->createMoveStrategyInterface()),
            new PlayerDto('name-2', $this->createMoveStrategyInterface())
        );
    }

    public function testCreate4PlayersSuccess(): void
    {
        $tilesPerPlayer = 5;

        $tileSetCorrect = $this->createTileSet();
        $tileSetCorrect->method('count')->willReturn($tilesPerPlayer);

        $stock = $this->createTileSet();
        $stock->method('popN')->with($tilesPerPlayer)->willReturn($tileSetCorrect);

        $factory = new PlayerSetFactory();

        $strategy1 = $this->createMoveStrategyInterface();
        $strategy2 = $this->createMoveStrategyInterface();

        $set = $factory->createPlayersSet(
            $stock,
            $tilesPerPlayer,
            new PlayerDto('name-1', $strategy1),
            new PlayerDto('name-2', $strategy2),
            new PlayerDto('name-3', $strategy2),
            new PlayerDto('name-4', $strategy1),
        );
        self::assertEquals(
            new PlayersSet(
                new Player('name-1', $tileSetCorrect, $strategy1),
                new Player('name-2', $tileSetCorrect, $strategy2),
                new Player('name-3', $tileSetCorrect, $strategy1),
                new Player('name-4', $tileSetCorrect, $strategy2),
            ),
            $set
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|TileSet
     */
    private function createTileSet()
    {
        return $this->createMock(TileSet::class);
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|MoveStrategyInterface
     */
    private function createMoveStrategyInterface()
    {
        return $this->createMock(MoveStrategyInterface::class);
    }
}
