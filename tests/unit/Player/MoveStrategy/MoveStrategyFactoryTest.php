<?php

declare(strict_types=1);

namespace AppTest\unit\Player\MoveStrategy;

use App\Player\MoveStrategy\AiMoveStrategy;
use App\Player\MoveStrategy\MoveStrategyFactory;
use PHPUnit\Framework\TestCase;

class MoveStrategyFactoryTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testCreateAiMoveStrategy(): void
    {
        $factory = new MoveStrategyFactory();
        $res = $factory->createAiMoveStrategy();
        self::assertInstanceOf(AiMoveStrategy::class, $res);
    }
}
