<?php

declare(strict_types=1);

namespace AppTest\unit\Player;

use App\Player\MoveStrategy\MoveStrategyInterface;
use App\Player\PlayerDto;
use PHPUnit\Framework\TestCase;

class PlayerDtoTest extends TestCase
{
    public function testInitialState(): void
    {
        $strategy = $this->createMoveStrategyInterface();
        $dto = new PlayerDto('name', $strategy);
        self::assertSame('name', $dto->getName());
        self::assertSame($strategy, $dto->getStrategy());
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|MoveStrategyInterface
     */
    private function createMoveStrategyInterface()
    {
        return $this->getMockBuilder(MoveStrategyInterface::class)->getMockForAbstractClass();
    }
}
