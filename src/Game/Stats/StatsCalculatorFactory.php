<?php

declare(strict_types=1);

namespace App\Game\Stats;

class StatsCalculatorFactory
{
    /**
     * @return StatsCalculator
     */
    public function createCalculator(): StatsCalculator
    {
        return new StatsCalculator();
    }
}
