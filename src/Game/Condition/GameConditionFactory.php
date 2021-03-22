<?php

declare(strict_types=1);

namespace App\Game\Condition;

class GameConditionFactory
{
    /**
     * @param int $uniqueValuesPerTileSide
     *
     * @return EndGameConditionDetector
     */
    public function createEndGameConditionDetector(int $uniqueValuesPerTileSide): EndGameConditionDetector
    {
        return new EndGameConditionDetector($uniqueValuesPerTileSide);
    }
}
