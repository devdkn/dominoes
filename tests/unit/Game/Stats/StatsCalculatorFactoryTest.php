<?php

declare(strict_types=1);

namespace AppTest\unit\Game\Stats;

use App\Game\Stats\StatsCalculator;
use App\Game\Stats\StatsCalculatorFactory;
use PHPUnit\Framework\TestCase;

class StatsCalculatorFactoryTest extends TestCase
{
    public function testCreateCalculator(): void
    {
        $factory = new StatsCalculatorFactory();
        $res = $factory->createCalculator();
        self::assertInstanceOf(StatsCalculator::class, $res);
    }
}
