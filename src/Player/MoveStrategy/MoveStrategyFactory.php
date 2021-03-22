<?php

declare(strict_types=1);

namespace App\Player\MoveStrategy;

use App\Player\MoveStrategy\Ai\MoveTilePicker;

class MoveStrategyFactory
{
    /**
     * @return AiMoveStrategy
     */
    public function createAiMoveStrategy(): AiMoveStrategy
    {
        return new AiMoveStrategy(new MoveTilePicker());
    }
}
