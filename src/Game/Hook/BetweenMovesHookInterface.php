<?php

declare(strict_types=1);

namespace App\Game\Hook;

interface BetweenMovesHookInterface
{
    /**
     * This method is called right before moving to the next move.
     */
    public function beforeNextMove(): void;
}
