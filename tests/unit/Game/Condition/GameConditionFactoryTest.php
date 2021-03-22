<?php

declare(strict_types=1);

namespace AppTest\unit\Game\Condition;

use App\Game\Condition\EndGameConditionDetector;
use App\Game\Condition\GameConditionFactory;
use PHPUnit\Framework\TestCase;

class GameConditionFactoryTest extends TestCase
{
    public function testCreateEndGameConditionDetector(): void
    {
        $factory = new GameConditionFactory();
        $res = $factory->createEndGameConditionDetector(7);
        self::assertInstanceOf(EndGameConditionDetector::class, $res);
    }
}
