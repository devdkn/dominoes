<?php

declare(strict_types=1);

namespace App\Move\MoveResult;

use App\Player\PlayerInfoInterface;

interface MoveResultInterface
{
    /**
     * @param PlayerInfoInterface        $player
     * @param MoveResultVisitorInterface $visitor
     */
    public function accept(PlayerInfoInterface $player, MoveResultVisitorInterface $visitor): void;
}
