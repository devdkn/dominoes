<?php

declare(strict_types=1);

namespace App\Move;

use App\Move\MoveResult\MoveResultInterface;

interface MoveInterface
{
    /**
     * Is the player allowed to take another action or should we advance to the next player.
     *
     * @return bool
     */
    public function advancePlayer(): bool;

    /**
     * Perform move.
     *
     * @return MoveResultInterface
     */
    public function execute(): MoveResultInterface;
}
